<?php

class Deelnemers_Model extends Model {

	function __construct() {		
		parent::__construct();
		
	}
	
	public function getUsers(){
		$query = $this->db->query("
						SELECT 
							*
						FROM 
							users 
						ORDER BY last_name ASC
						") or die('Error: bottles_Model getBottles');
	
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$data = $query->fetchAll();
		return $data;
	}


}