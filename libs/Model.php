<?php

class Model {

	function __construct() {
		$this->db = new Database();
		// show errors
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	

}