<?php

// INDEX CONTROLLER
class track extends Controller {

	function __construct() {
		parent::__construct();

	}

	function index() {
		//$this -> view -> users = $this -> model -> getUsers();
		$this -> view -> render('track/index');
	}
	
	


}
