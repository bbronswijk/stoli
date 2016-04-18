<?php

// INDEX CONTROLLER
class notificaties extends Controller {

	function __construct() {
		parent::__construct();

	}

	function index() {
		$this -> view -> notificaties = $this -> model -> getNotificaties();
		$this -> view -> render('notificaties/index');
	}
	
	function loadMore(){
		$this -> model -> loadMore();
	}


}
