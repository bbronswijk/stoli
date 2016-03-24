<?php


Class Auth {
	
	public static function checkLogin(){
		@session_start();
		if (isset($_SESSION['fb_access_token'])){
			$accessToken = $_SESSION['fb_access_token'];
		}
		
		
		// get_class($this) is the current controller
		// check if there is an acces token 
		if( $_SESSION['fb_access_token'] != false){
			// check if the accestoken is still valid			
			$auth = Model::checkAccesToken($accessToken);
			if( $auth != TRUE ){
				if ( get_class($this) != 'login') {
					// accesstoken is invalid
					// refresh page and go to the login page	
					header('location: '.URL.'login');
				}
			}
		} else{
			if ( get_class($this) != 'login') {
				// there is no accesstoken in the session
				// refresh page and go to the login page	
				header('location: '.URL.'login');	
			}
		}
		
		return true;
	}
	
}
