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
	
	function users($trophy_id){
		$this -> view -> trophy = $this -> model -> getTrophy($trophy_id);
		$this -> view -> users = $this -> model -> getTrophyUsers($trophy_id);
		$this -> view -> render('trophies/users');
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
