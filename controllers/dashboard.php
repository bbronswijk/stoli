<?php

// INDEX CONTROLLER
class dashboard extends Controller {

	function __construct() {
		parent::__construct();

	}

	function index() {
		//$this -> view -> dates = $this -> model -> getDates();
		$this -> view -> render('dashboard/index');
	}
	
	function getDates(){
		$this -> model -> getDates();
	}
	
	function getUsers(){
		$this -> model -> getUsers();
	}
	
	function getPresence(){
		$this -> model -> getPresence();
	}

}
