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
	
	function trophies($user_id){
		$this -> view -> user = $this -> model -> getUser($user_id);
		$this -> view -> trophies = $this -> model -> getUserTrophies($user_id);
		$this -> view -> render('deelnemers/trophies');
		
	}


}
