<?php

// INDEX CONTROLLER
class trophies extends Controller {

	function __construct() {
		parent::__construct();

	}

	function index() {
		//require 'models/index_model.php';
		//$model = new Index_Model();

		$this -> view -> msg = 'This is the view content of trophies from the trophies controller';
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
