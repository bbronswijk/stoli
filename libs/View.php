<?php

class View {

	function __construct() {}

	public function render($name, $includePanel = false)
	{
		$this -> getHelper('body');
		$this -> bodyHelper -> controller = $this->controller;
		
		if($includePanel === false){
			// wordt op elke pagina geladen.		
			$this -> getHelper('menu');
			$this -> menuHelper -> controller = $this->controller;
			$this -> getHelper('quote');
						
			require 'templates/header.php';
			require 'templates/panel.php';
			require 'views/' . $name . '.php';
			require 'templates/panel_footer.php';
			// TODO fix this
			if( $this->controller == 'bottles' ){
				require 'views/bottles/add_modal.php';
				require 'views/bottles/badge_modal.php';
			} 
			if( $this->controller == 'track' ){
				require 'views/track/add_modal.php';
			} 
			require 'templates/footer.php';
		}else{
			require 'templates/header.php';
			require 'views/' . $name . '.php';
			require 'templates/footer.php';
		}
		
	}
	
	public function getHelper($helper){
		$file = 'helpers/'.$helper.'Helper.php';

		if (file_exists($file)) {
			require $file;			
		}
		
		// instantiate helper
		$helperClass = $helper.'Helper';		
		$this -> $helperClass = new $helperClass;
		
	}
	
	public function get($name, $model = false){
		// load controller			
		$file = 'controllers/'.$name.'.php';

		if (file_exists($file)) {
			require $file;			
		}
		
		$controller = new $name;
		
		// load model 
		if( $model != false ){
			$controller->loadModel($name);
		}
		
		// the template gets rendered in the controller using renderTemplate 
		
		// render the default index function of the just required controller
		// additional options may be necessary
		
		$controller->index();
		
		

	}
	
	public function renderTemplate($name){
		require $name . '.php';
	}

}