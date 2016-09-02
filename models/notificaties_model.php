<?php

class Notificaties_Model extends Model {

	

	function __construct() {		
		parent::__construct();
		$this->onlineUser = Session::get('fb_user_id');	
	}
	
	public function getNotificaties(){
		// returns the id of the last notification the user has seen
		//$last_note = $this->_lastNotification();
		
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
						ORDER BY 
							notifications.id DESC		
						LIMIT 
							5			
						") or die('Error: notificaties_Model getNotificaties');
	
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$data = $query->fetchAll();
		return $data;		
	}
	
	public function loadMore(){
		// returns the id of the last notification the user has seen
		//$last_note = $this->_lastNotification();
	
		$offset = $_POST['offset'];
	
		$query = $this->db->prepare("
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
						ORDER BY 
							notifications.id DESC		
						LIMIT 
							8
						OFFSET ".$offset
						
						) or die('Error: notificaties_Model loadMore');
	
		$query->execute();
		
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$data = $query->fetchAll();
		
		echo json_encode($data);		
	}
	
	

}