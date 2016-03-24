<?php

// INDEX CONTROLLER
class dashboard extends Controller {

	function __construct() {
		parent::__construct();

	}

	function index() {
		//require 'models/index_model.php';
		//$model = new Index_Model();
		//$this -> view -> user = Session::get('fb_user_id');
		$this -> view -> msg = 'This is the view content of dashboard from the dashboard controller';
		$this -> view -> render('dashboard/index');
	}

}
