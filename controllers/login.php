<?php

// INDEX CONTROLLER
class login extends Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		// check if there is a fb accestoken in a session
		$accessToken = Session::get('fb_access_token');
		
		if ( $accessToken != false ) {
			// if a user is logged in skip the login screen and proceed to the dashnoard
			header('location: '.URL.'dashboard');	
		} else {
			// no user is logged in > get the facebook object
			$fb = new Facebook\Facebook([
				'app_id' => FBAPPID, 
				'app_secret' => FBSECRET,
				'default_graph_version' => FBVERSION
			]);
				
			$helper = $fb->getRedirectLoginHelper();
			
			// send the loginUrl to the view 
			$this -> view -> loginUrl = $helper->getLoginUrl(URL.'login/auth') ;
	
			$this -> view -> render('login/index',true);
		}
	}
	
	function auth(){		
		// authenication proces after user is logged in.
		$auth = $this -> model -> auth();
		
		if($auth == TRUE){			
			header('location: '.URL.'dashboard');
		}else{
			$this -> view -> msg = $auth;
			$this -> view -> render('login/auth');
		}		
	}
	
	function logout(){
		$this -> model -> logout();
	}

}
