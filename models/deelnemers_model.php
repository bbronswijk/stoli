<?php

class Deelnemers_Model extends Model {

	function __construct() {		
		parent::__construct();
		
	}
	
	public function getUsers(){
		$query = $this->db->query("SELECT
									  users.id,
									  users.picture,
									  users.first_name,
									  users.last_name,
									  SUM(trophies.id= 13) as bottles,
									  SUM(trophies.type='trophy') + SUM(trophies.type='badge') as trophies,
									  SUM(trophies.xp) as xp
									FROM
									  users
									LEFT JOIN bottles_trophies ON 
									  bottles_trophies.user_id = users.id
									LEFT JOIN trophies ON 
									  bottles_trophies.trophy_id = trophies.id
									GROUP BY 
									  users.id
									ORDER BY
									  users.last_name ASC
								") or die('Error: bottles_Model getBottles');
		
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$data = $query->fetchAll();
		return $data;
	}
	
	// get single user
	public function getUser($user_id){
		
				
		$query = $this->db->prepare("SELECT
									  users.id,
									  users.picture,
									  users.first_name,
									  users.last_name,
									  SUM(trophies.id= 13) as bottles,
									  SUM(trophies.type='trophy') + SUM(trophies.type='badge') as trophies,
									  SUM(trophies.xp) as xp
									FROM
									  users
									LEFT JOIN bottles_trophies ON 
									  bottles_trophies.user_id = users.id
									LEFT JOIN trophies ON 
									  bottles_trophies.trophy_id = trophies.id
									WHERE 
									  user_id = :user_id
									GROUP BY 
									  users.id
									ORDER BY
									  users.last_name ASC
								") or die('Error: bottles_Model getBottles');
								
		$query->bindParam(':user_id', $user_id);
		
		$query->execute();		
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$data = $query->fetchAll();
		
		return $data;
	}
	
	
	public function getUserTrophies($user_id){
		$query = $this->db->prepare("SELECT
										  *
										FROM
										  `bottles_trophies`
										LEFT JOIN
										  trophies ON bottles_trophies.trophy_id = trophies.id
										WHERE
										  user_id = :user_id && trophies.type != 'xp'
								") or die('Error: bottles_Model getBottles');
	
		$query->bindParam(':user_id', $user_id);
		$query->execute();
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$data = $query->fetchAll();
		return $data;
	}
	
	


}