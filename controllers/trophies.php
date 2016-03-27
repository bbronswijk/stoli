<?php

// INDEX CONTROLLER
class trophies extends Controller {

	function __construct() {
		parent::__construct();

	}

	function index() {
		// check completed trophies
		$this -> view -> userTrophies = $this -> model -> getTrophies();
		// get list of all available trophies
		$this -> view -> trophies = $this -> model -> getAllTrophies();
		$this -> view -> render('trophies/index');
	}

	function insertTrophy(){
		$this->model->insertTrophy();
	}
	
	function updateTrophy(){
		$this->model->updateTrophy();
	}
	
	function checkCompleted(){
		$this->model->checkCompleted();
	}

}
