<?php

// INDEX CONTROLLER
class user extends Controller {

	function __construct() {
		parent::__construct();

	}

	function index() {
		$this -> view -> userdata = $this -> model -> getUser();
		$this -> view -> numBottles = $this -> model -> countBottles();
		$this -> view -> renderTemplate('templates/user');

	}
	
	function getStats(){
		$this->model->getStats();
	}

}
