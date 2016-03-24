<?php

class Login_Model extends Model {
	public function __construct() {
		parent::__construct();
	}

	public function auth() {
		
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
			echo '( 1 ) Facebook SDK returned an error: ' . $e -> getMessage();
			
			// set custom session 
			// TODO check why $helper->getLoginUrl() runs twice..
			$session = $_SESSION['FBRLH_' . 'state'];
			$url = 'https://www.facebook.com/v2.5/dialog/oauth?client_id=1725206204365263&state='.$session.'&response_type=code&sdk=php-sdk-5.1.2&redirect_uri=http%3A%2F%2Flocalhost%3A8080%2Fstoli%2Flogin%2Fauth&scope=';
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
		$tokenMetadata -> validateAppId('1725206204365263');
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
			$request = $fb->get('/me?fields=id,name,first_name,last_name,picture.height(150)',$accessToken);
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
			date_default_timezone_set('Europe/Amsterdam');
			$datum = date('Y/m/d h:i:s', time());
			// put new user in DB here				
			$add = $this->db->prepare("INSERT INTO users
				(id, first_name, last_name, picture, created, modified )
				VALUES (:id, :first_name, :last_name, :picture, :created, :modified)
				");
			$add->bindParam(':id', $profile['id']);
			$add->bindParam(':first_name', $profile['first_name']);
			$add->bindParam(':last_name', $profile['last_name']);
			$add->bindParam(':picture', $profile['picture']['url']);
			$add->bindParam(':created', $datum);
			$add->bindParam(':modified', $datum);
			$count = $add->execute();
			
			if($count > 0){
				// create notification --> should have its own model?
				$user = $profile['id'];
				$message = 'heeft een nieuw account aangemaakt';
				
				// create new notification
				$query = $this->db->prepare("INSERT INTO notifications
													(user_id, message)
													VALUES (:user_id, :message)
												")or die('Error: notifications_Model createNotification');
				$query->bindParam(':user_id', $user);
				$query->bindParam(':message', $message);
				$query->execute();				
			}
		}
		
		// tell controller authentication is done
		return TRUE;
	}

}
