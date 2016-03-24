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
		
		// create new notification
		$query = $this->db->prepare("INSERT INTO notifications
											(user_id, message)
											VALUES (:user_id, :message)
										")or die('Error: notifications_Model createNotification');
		$query->bindParam(':user_id', $user);
		$query->bindParam(':message', $message);
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

}