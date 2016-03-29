<?php

class User_Model extends Model {

	function __construct() {		
		parent::__construct();
		
	}
	
	// get the name and picture of the onlne user
	public function getUser(){
		$userId = Session::get('fb_user_id');
		$query = $this->db->query("
						SELECT 
							id,
							first_name,
							last_name,
							picture
						FROM 
							users 
						WHERE 
							id=".$userId
						) or die('Error: user_Model getUser');
	
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$data = $query->fetchAll();
		return $data;		
	}
	
	// get the amount of bottles from the online user
	public function countBottles(){
		$userId = Session::get('fb_user_id');
		$query = $this->db->query("
						SELECT 
							*
						FROM 
							bottles
						WHERE 
							user_id = ".$userId
						) or die('Error: user_Model countBottles');
	
		
		return $query->rowCount();
			
	}
	
	
	// get the amount of xp from the online-user
	public function getStats(){
		$user_id = Session::get('fb_user_id');
		
		$query = $this->db->prepare("SELECT 
										trophies.type,
										trophies.xp 
									FROM 
										bottles_trophies 
									LEFT JOIN trophies ON
										bottles_trophies.trophy_id = trophies.id
									WHERE 
										bottles_trophies.user_id = :user_id
									") or die('Error: user_Model getStats');
	
		$query->bindParam(':user_id', $user_id);
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->execute();
		$data = $query->fetchAll();
			
		echo json_encode($data);
	}
	
	

}