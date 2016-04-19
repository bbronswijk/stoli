<?php

class Ideas_Model extends Model {

	

	function __construct() {		
		parent::__construct();
		$this->onlineUser = Session::get('fb_user_id');	
	}
	
	public function getIdeas(){
		
		$query = $this->db->prepare("SELECT 
										*
									FROM
										ideas
									ORDER BY id DESC
										")or die('Error: Ideas_Model getIdeas');
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->execute();
		$data = $query->fetchAll();
		return $data;				
	}
	


	function insertIdea(){
		$last_name = $_POST['last_name'];
		$description = $_POST['description'];
		
		// create new trophy
		$query = $this->db->prepare("INSERT INTO ideas
											(last_name, description)
											VALUES (:last_name, :description)
										")or die('Error: Ideas_Model insertIdea');
		$query->bindParam(':last_name', $last_name);
		$query->bindParam(':description', $description);
		$count = $query->execute();

		echo $count;
	}
	
	

}