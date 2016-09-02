<?php

class Notifications_Model extends Model {

	

	function __construct() {		
		parent::__construct();
		$this->onlineUser = Session::get('fb_user_id');	
	}
	
	public function getNotifications(){
		// returns the id of the last notification the user has seen
		$last_note = $this->_lastNotification();
		
		$query = $this->db->query("
						SELECT 
							notifications.id,
							notifications.user_id,
							notifications.message,
							notifications.date,
							users.last_name,
							users.picture
						FROM 
							notifications
						LEFT JOIN users ON
							notifications.user_id = users.id
						WHERE 
							notifications.id > ".$last_note."
						ORDER BY notifications.id DESC		
						LIMIT 8					
						") or die('Error: notifications_Model getNotifications');
	
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$data = $query->fetchAll();
		return $data;		
	}
	
	//ORDER BY bottles.date DESC
	
	public function countNew(){	
		// returns the id of the last notification the user has seen
		$last_note = $this->_lastNotification();
				
		$query = $this->db->query("
						SELECT 
							*
						FROM 
							notifications
						WHERE 
							id > ".$last_note
						) or die('Error: user_Model countBottles');
	
		//WHERE user_id=".$userId
		if($query->rowCount() > 8){
			return 8;
		} else{
			return $query->rowCount();
		}
			
	}
	
	function _lastNotification(){
		$userId = $this->onlineUser;
				
		$last = $this->db->query("
						SELECT 
							notification_id
						FROM 
							notifications_users
						WHERE
							user_id = ".$userId					
						) or die('Error: notifications_Model getNotifications');
	
		
		$last->setFetchMode(PDO::FETCH_ASSOC);
		$last_note = $last->fetchAll();
				
		// if the user is not in the database set value 0 so alle notifications will be shown		
		if( $last->rowCount() === 0 ){
			$last_note = 0;
		} else{
			$last_note = $last_note[0]['notification_id'];
		}
		
		// returns the id of the last notification the user has seen
		return $last_note;
	}
	
	function clearNotifications(){
		
		// get id of last shown notification
		$id = $_POST['notification'];
		$user = $_POST['user_id'];
		
		$query = $this->db->prepare("
						SELECT 
							*
						FROM 
							notifications_users
						WHERE
							user_id = :user_id
						") or die('Error: notifications_Model clearNotifications');
						
		$query->bindParam(':user_id', $user);
		$query->execute();

		
		// check if user exists in notifications user table
		if($query->rowCount() > 0){			
			// if so update UPDATE MyGuests SET lastname='Doe' WHERE id=2
			$query = $this->db->prepare("UPDATE
											notifications_users
										SET
											notification_id = :notification_id
										WHERE
											user_id = :user_id
										")or die('Error: notifications_Model clearNotifications');
			$query->bindParam(':notification_id', $id);
			$query->bindParam(':user_id', $user);
			$count = $query->execute();
			echo $count;
		} else{
			$query = $this->db->prepare("INSERT INTO notifications_users
											(notification_id, user_id)
											VALUES (:notification_id, :user_id)
										")or die('Error: notifications_Model clearNotifications');
			$query->bindParam(':notification_id', $id);
			$query->bindParam(':user_id', $user);
			$count = $query->execute();
			echo $count;
		}
		
	}


	function createNotification(){
		
		$user = $_POST['user_id'];
		$message = $_POST['notification'];
		$date = date('d-m-Y');
		
		
		// create new notification
		$query = $this->db->prepare("INSERT INTO notifications
											(user_id, message, date)
											VALUES (:user_id, :message, :date)
										")or die('Error: notifications_Model createNotification');
		$query->bindParam(':user_id', $user);
		$query->bindParam(':message', $message);
		$query->bindParam(':date', $date);
		$query->execute();
		
		$last_id = $this->db->lastInsertId();
				
		$stmt = $this->db->query("
						SELECT 
							last_name,
							picture
						FROM 
							users
						WHERE
							id = ".$user					
						) or die('Error: notifications_Model createNotification');
	
		
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$name = $stmt->fetchAll();
		$json = json_encode($name);
		
		$json = json_decode($json);
		
		$json['last_id'] = $last_id;
		
		echo json_encode($json);
		
		//$count = $query->execute();
		//echo $count;
	}
	
	public function _getUsersEmail(){
		$query = $this->db->query("
						SELECT
							email
						FROM
							users
						WHERE
							email IS NOT NULL
						") or die('Error: notifications_Model _getUsersEmail');
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$stmt = $query->fetchAll();
		
		// IS NOT NULL
		//= 'brambronswijk@gmail.com'
		
		return $stmt;
	}
	
	function sendNotification(){
				
		$subject = $_POST['subject'];
		$message = '<table align="center" bgcolor="#F2F2F2" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">'.
					'<tbody><tr><td><h1 style="color: #df1a25;font-family: Helvetica, Arial, sans-serif; font-size: 30px; font-style: normal; font-weight: 600; line-height: 36px; letter-spacing: normal; margin: 0; padding: 40px 20px 0 20px; text-align: center">WiebetaaltdeStoli.com</h1></td></tr><tr><td align="center" style="padding:20px" valign="top">'.
					'<table align="center" border="0" cellpadding="0" cellspacing="0" style="max-width: 640px" width="100%"><tbody><tr>'.
					'<td align="center" valign="top"><table align="center" bgcolor="#FFFFFF" border="0" cellpadding="0" cellspacing="0"style="background-color: #ffffff; border-bottom: 2px solid #e5e5e5; border-radius: 4px"width="100%">'.
					'<tbody><tr><td align="center" style="padding: 20px" valign="top"><table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td style="padding-bottom: 0px" valign="top">'.
					'<h1 style="color: #606060; font-family: Helvetica, Arial, sans-serif; font-size: 28px; font-style: normal; font-weight: 600; line-height: 36px; letter-spacing: normal; margin: 0; padding: 0; text-align: left">'.
					$_POST['title'].
					'</h1></td></tr><tr><td style="padding-bottom: 40px" valign="top"><p style="color: #606060; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 0; margin-top: 0; text-align: left">'.
					$_POST['text'].
					'<a href="http://wiebetaaltdestoli.com" style="color:#ffffff;text-decoration:none;font-size:14px;font-weight:bold;display:block;padding:7px;margin-top:15px;margin-bottom:15px;background:#df1a25;border-radius:5px;width:100px;text-align:center;" target="_blank">Naar website</a>'.
					'</p></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align="center" valign="top">'.
					'<table border="0" cellpadding="0" cellspacing="0" width="100%"><tbody><tr><td align="center" valign="top" style="font-family: Helvetica; font-size: 12px; line-height: 24px; padding-top: 10px; padding-bottom: 40px; text-align: center">'.
					'<a href="http://wiebetaaltdestoli.com" style="color:#6f6f6f;text-decoration:none;" target="_blank">wiebetaaltdestoli.com</a>'.					
					'</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>';
			
		/* Start of headers */
		$headers = "From: WiebetaaltdeStoli.com <info@wiebetaaltdestoli.com>\n".
				"Reply-To: info@wiebetaaltdestoli.nl";
		$headers .= "MIME-Version: 1.0\r\n";
		/// TODO BRAM content type
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		$emails = $this->_getUsersEmail();
				
		foreach( $emails as $key => $value){
			$to = $emails[$key]['email'];
		
			$flgchk = mail ("$to", "$subject", "$message", "$headers");
		}
		
		
			
		if($flgchk){
			// verstuurd
			echo json_encode('mails verstuurd');
		}
		else{
			// error
			echo json_encode($flgchk);
		}
	}
}