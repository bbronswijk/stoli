<?php

class Bootstrap {

	function __construct() {
		
		if( !empty($_GET['url']) ){
			$url = $_GET['url'];
		} else{
			$url = 'index';
		}
		
		$url = rtrim($url, '/');
		$url = explode('/', $url);

		// url[0] page
		// url[1] method/action
		// url[2] vars/param for method/action
		
		
		
		$file = 'controllers/' . $url[0] . '.php';
		if (file_exists($file)) {
			require $file;
			
		} else {
			// 404 redirect to index
			require 'controllers/index.php';
			$controller = new index;
			$controller->index(); //404			
			return false;
		}
		
		// initiate new controller
		$controller = new $url[0];
		// load model for controller if exists
		$controller->loadModel($url[0]);
		
		// set methods and variables
		if (isset($url[2])) {
			// if param is set
			$controller->{$url[1]}($url[2]);
		} else {
			if (isset($url[1])) {
				// if only action is set check if it exists
				if(method_exists($controller, $url[1])){
					$controller->{$url[1]}();
				} else{
					$controller->index(); // 404
				}				
			} else{
				// if no action is set 
				$controller->index();
			}
		}
	}

}