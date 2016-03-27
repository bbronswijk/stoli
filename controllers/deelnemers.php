<?php

// INDEX CONTROLLER
class deelnemers extends Controller {

	function __construct() {
		parent::__construct();

	}

	function index() {
		$this -> view -> users = $this -> model -> getUsers();
		$this -> view -> render('deelnemers/index');
	}
	
	


}
