<?php

class Dashboard_Model extends Model {

	function __construct() {		
		parent::__construct();
		
	}
	
	public function getDates(){
		$query = $this->db->prepare("SELECT
									  *
									FROM
									  bottles
									ORDER BY
									  date DESC
									") or die('Error: Dashboard_Model getDates');
	
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->execute();
		$data = $query->fetchAll();
		echo json_encode($data);
	}
	
	public function getUsers(){
		$query = $this->db->query("SELECT
									  users.last_name,
									  SUM(trophies.id= 13) as bottles,
									  SUM(trophies.id= 11) as most,
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
		$query->execute();
		$data = $query->fetchAll();
		echo json_encode($data);
	}


}