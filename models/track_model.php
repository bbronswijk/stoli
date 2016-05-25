<?php

class Track_Model extends Model {

	function __construct() {		
		parent::__construct();
		
	}
		
	public function insertBottle(){
		    $status = 1;
					
			// put new user in DB here				
			$query = $this->db->prepare("INSERT INTO track
				( bought, owner, status )
				VALUES ( :date, :user_id, :status )
				");
			$query->bindParam(':user_id', $_POST['user_id']);
			$query->bindParam(':date', $_POST['date']);
			$query->bindParam(':status', $status);
			
			$query->execute();
			$bottle_id = $this->db->lastInsertId();
			
			echo $bottle_id;
			return;
	}
	
	public function updateBottle(){
					
			// put new user in DB here				
			$query = $this->db->prepare("UPDATE 
											track
										SET
											status = :status ,
											empty = :date
										WHERE
											id = :bottle_id 
				")or die('Error: Track_Model updateBottle');
				
			$query->bindParam(':bottle_id', $_POST['bottle_id']);
			$query->bindParam(':date', $_POST['date']);
			$query->bindParam(':status', $_POST['status']);
			
			$query->execute();
			
			echo $_POST['bottle_id'];
			return;
	}
		
	public function getUsers(){
						
		$query = $this->db->prepare("
						SELECT 
							id,
							last_name
						FROM 
							users 
						ORDER BY 
							last_name DESC
						") or die('Error: Track_Model getUsers');
						
		$query->execute();
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$data = $query->fetchAll();
		return $data;
	}
	
	public function getTrackers(){
						
		$query = $this->db->prepare("
						SELECT 
						  track.id,
						  track.bought,
						  track.owner,
						  track.status,
						  track.empty,
						  users.first_name,
						  users.last_name
						FROM 
							track
						LEFT JOIN users ON
  							track.owner = users.id
  						WHERE 
  							track.status != 4
						ORDER BY 
							bought DESC
						") or die('Error: Track_Model getTrackers');
						
		$query->execute();		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$data = $query->fetchAll();
		echo json_encode($data);
		//return $data;
	}

}