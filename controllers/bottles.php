<?php

// INDEX CONTROLLER
class bottles extends Controller {

	function __construct() {
		parent::__construct();

	}

	function index() {
		$this -> view -> users = $this -> model -> getUsers();
		$this -> view -> render('bottles/index');

	}
	
	function insertBottle(){
		$this->model->insertBottle();
	}
	
	function deleteBottle(){
		$this->model->deleteBottle();	
	}
	
	function getBottles(){
		$this -> model -> getBottles();
	}
	
	function getTrophies(){
		$this -> model -> getTrophies();
	}
	
	function getAttendees(){
		$this -> model -> getAttendees();
	}

}
