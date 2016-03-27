<?php

class Trophies_Model extends Model {

	

	function __construct() {		
		parent::__construct();
		$this->onlineUser = Session::get('fb_user_id');	
	}
	
	public function getTrophies(){
		$user_id = Session::get('fb_user_id');
		
		$query = $this->db->prepare("SELECT 
										trophy_id
									FROM
										bottles_trophies
									WHERE
										user_id = :user_id
										")or die('Error: trophy_Model getTrophies');
		$query->bindParam(':user_id', $user_id);
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->execute();
		$data = $query->fetchAll();
		return $data;				
	}
	
	public function getAllTrophies(){		
		$query = $this->db->query("
						SELECT 
							id,
							img,
							description,
							xp
						FROM 
							trophies
						WHERE 
							type != 'xp' "			
						) or die('Error: trophy_Model getALLTrophies');
	
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$data = $query->fetchAll();
		return $data;		
	}

	function insertTrophy(){
		$bottle_id = $_POST['bottle_id'];
		$user_id = $_POST['user_id'];
		$trophy_id = $_POST['badge_id'];
		
		// create new trophy
		$query = $this->db->prepare("INSERT INTO bottles_trophies
											(bottle_id, user_id, trophy_id)
											VALUES (:bottle_id, :user_id, :trophy_id)
										")or die('Error: trophy_Model insertTrophy');
		$query->bindParam(':bottle_id', $bottle_id);
		$query->bindParam(':user_id', $user_id);
		$query->bindParam(':trophy_id', $trophy_id);
		$count = $query->execute();

		echo $count;
	}
	
	function updateTrophy(){
		$bottle_id = $_POST['bottle_id'];
		$user_id = $_POST['user_id'];
		$trophy_id = $_POST['badge_id'];
		
		// delete existing trophy of user
		$delete = $this->db->prepare("DELETE 
									FROM 
										bottles_trophies
									WHERE
										trophy_id = :trophy_id
										")or die('Error: trophy_Model updateTrophy');
		$delete->bindParam(':trophy_id', $trophy_id);
		$delete->execute();
		
		// create new trophy
		$query = $this->db->prepare("INSERT INTO bottles_trophies
											(bottle_id, user_id, trophy_id)
											VALUES (:bottle_id, :user_id, :trophy_id)
										")or die('Error: trophy_Model updateTrophy');
		$query->bindParam(':bottle_id', $bottle_id);
		$query->bindParam(':user_id', $user_id);
		$query->bindParam(':trophy_id', $trophy_id);
		$count = $query->execute();

		echo $count;
	}
	
	function checkCompleted(){
		$user_id = $_POST['user_id'];
		
		// create new notification
		$query = $this->db->prepare("SELECT 
										trophy_id
									FROM
										bottles_trophies
									WHERE
										user_id = :user_id
										")or die('Error: trophy_Model checkCompleted');
		$query->bindParam(':user_id', $user_id);
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->execute();
		$data = $query->fetchAll();
		echo json_encode($data);
	}

}