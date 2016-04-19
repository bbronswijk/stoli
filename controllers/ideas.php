<?php

// INDEX CONTROLLER
class ideas extends Controller {

	function __construct() {
		parent::__construct();

	}

	function index() {
		$this -> view -> ideas = $this -> model -> getIdeas();
		$this -> view -> render('ideas/index');
	}
	
	function insertIdea(){
		$this -> model -> insertIdea();
	}


}
