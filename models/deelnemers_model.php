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
									  COUNT(DISTINCT bottles_trophies.bottle_id) as bottles,
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
									  users.id ASC
								") or die('Error: bottles_Model getBottles');
	
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$data = $query->fetchAll();
		return $data;
	}
	
	


}