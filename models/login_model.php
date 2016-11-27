<?php

class Login_Model extends Model {
	public function __construct() {
		parent::__construct();
	}
	
	public function logout(){
		Session::destroy();
		echo json_encode('destroyed');
	}

	public function auth() {
		date_default_timezone_set('Europe/Amsterdam');
			
		Session::init();
		
		$fb = new Facebook\Facebook([
			'app_id' => FBAPPID, 
			'app_secret' => FBSECRET,
			'default_graph_version' => FBVERSION
		]);
				
		$helper = $fb -> getRedirectLoginHelper();
		
		try {
			$accessToken = $helper -> getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			echo 'Graph returned an error: ' . $e -> getMessage();
			exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			//echo '( b1 ) Facebook SDK returned an error: ' . $e -> getMessage();
			
			// set custom session 
			// TODO check why $helper->getLoginUrl() runs twice..
			$session = $_SESSION['FBRLH_' . 'state'];
			$url = 'https://www.facebook.com/v2.5/dialog/oauth?client_id='.FBAPPID.'&state='.$session.'&response_type=code&sdk=php-sdk-5.1.2&redirect_uri='.URL.'login%2Fauth&scope=';
			header('location: '.$url);
			
			exit;
		}

		if (!isset($accessToken)) {
			if ($helper -> getError()) {
				header('HTTP/1.0 401 Unauthorized');
				echo "Error: " . $helper -> getError() . "\n";
				echo "Error Code: " . $helper -> getErrorCode() . "\n";
				echo "Error Reason: " . $helper -> getErrorReason() . "\n";
				echo "Error Description: " . $helper -> getErrorDescription() . "\n";
			} else {
				header('HTTP/1.0 400 Bad Request');
				echo 'Bad request';
			}
			exit ;
		}

		// The OAuth 2.0 client handler helps us manage access tokens
		$oAuth2Client = $fb -> getOAuth2Client();
		$tokenMetadata = $oAuth2Client -> debugToken($accessToken);
		$tokenMetadata -> validateAppId(FBAPPID);
		$tokenMetadata -> validateExpiration();

		if (!$accessToken -> isLongLived()) {
			try {
				$accessToken = $oAuth2Client -> getLongLivedAccessToken($accessToken);
			} catch (Facebook\Exceptions\FacebookSDKException $e) {
				echo "<p>Error getting long-lived access token: " . $helper -> getMessage() . "</p>\n\n";
				exit ;
			}

		}

		Session::set('fb_access_token', (string)$accessToken);
		
		// getting basic info about logged-in user
		try {
			$request = $fb->get('/me?fields=id,name,first_name,last_name,email,picture.height(150)',$accessToken);
			$profile = $request->getGraphUser();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		Session::set('fb_user_id', $profile['id']);
		// check if user already exists in the database
		$sth = $this->db->prepare("SELECT id from users WHERE id = :id");
		$sth->execute(array(
			':id' => $profile['id']
		));
		
		$count = $sth->rowCount();
		
		if( $count == 0 ){
			$datum = date('Y/m/d h:i:s', time());
			
			if(!empty($profile['email'])){
				$email = $profile['email'];
			} else{
				$email = 'no-reply@wiebetaaltdestoli.com';
			}
			
			// put new user in DB here				
			$add = $this->db->prepare("INSERT INTO users
				(id, first_name, last_name, email, picture, created, modified )
				VALUES (:id, :first_name, :last_name, :email, :picture, :created, :modified)
				");
			
			
			
			$add->bindParam(':id', $profile['id']);
			$add->bindParam(':first_name', $profile['first_name']);
			$add->bindParam(':last_name', $profile['last_name']);
			$add->bindParam(':email', $email);
			$add->bindParam(':picture', $profile['picture']['url']);
			$add->bindParam(':created', $datum);
			$add->bindParam(':modified', $datum);
			// increase $count
			$count = $add->execute();
			
			// double check see above
			if($count > 0){
				// create notification --> should have its own model?
				$user = $profile['id'];
				$message = 'heeft een nieuw account aangemaakt';
				$datumNote = date('d-m-Y h:i:s', time());
				// create new notification
				$query = $this->db->prepare("INSERT INTO notifications
													(user_id, message, date)
													VALUES (:user_id, :message, :date)
												")or die('Error: notifications_Model createNotification');
				$query->bindParam(':user_id', $user);
				$query->bindParam(':message', $message);
				$query->bindParam(':date', $datumNote);
				$query->execute();				
			}
		} else if( $count == 1 ){
			$datum = date('Y/m/d h:i:s', time());
			
			// put new user in DB here				
			$update = $this->db->prepare("UPDATE 
											users
										SET
											first_name = :first_name, 
											last_name = :last_name, 
											email = :email, 
											picture = :picture, 
											modified = :modified
										WHERE
											id = :id
				") or die('Error: notifications_Model updateUser');
				
			$update->bindParam(':id', $profile['id']);
			$update->bindParam(':first_name', $profile['first_name']);
			$update->bindParam(':last_name', $profile['last_name']);
			$update->bindParam(':email', $profile['email']);
			$update->bindParam(':picture', $profile['picture']['url']);
			$update->bindParam(':modified', $datum);
			// increase $count
			$update->execute();
		}
		
		// tell controller authentication is done
		return TRUE;
	}

}
