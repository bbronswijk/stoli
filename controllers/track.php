<?php

// INDEX CONTROLLER
class track extends Controller {

	function __construct() {
		parent::__construct();

	}

	function index() {
		$this -> view -> users = $this -> model -> getUsers();
		//$this -> view -> trackers = $this -> model -> getTrackers();
		$this -> view -> render('track/index');
	}
	
	function getTrackers(){
		$this -> model -> getTrackers();
	}
	
	function insertBottle(){
		$this -> model -> insertBottle();
	}
	
	function updateBottle(){
		$this -> model -> updateBottle();
	}

}
