<?php

class Controller {

	function __construct() {
		// check if user is logged in with facebook
		//@session_start();
		Session::init();
		
		$this -> view = new View();
		$this -> view -> controller = get_class($this);
		
		if (isset($_SESSION['fb_access_token'])){
			$accessToken = $_SESSION['fb_access_token'];
			$this -> view -> user = Session::get('fb_user_id');
		} else {
			if ( get_class($this) != 'login') {
				header('location: '.URL.'login');	
			} 
		}			
	}

	public function loadModel($name) {
		$path = 'models/' . $name . '_model.php';
		
		// include models
		if (file_exists($path)) {
			require $path;
			$modelName = $name . '_Model';
			$this -> model = new $modelName;
		}
	}

}
