<?php

// INDEX CONTROLLER
class index extends Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {	
		//$this -> view -> bottles = $this -> model -> getBottles();
		//$this -> view -> attendees = $this -> model -> getAttendees();
		$this -> view -> render('dashboard/index');
	}

}
