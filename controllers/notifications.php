<?php

// NOTIFICATIONS CONTROLLER
class notifications extends Controller {

	function __construct() {
		parent::__construct();

	}

	function index() {
		$this -> view -> notifications = $this -> model -> getNotifications();
		$this -> view -> new = $this -> model -> countNew();
		$this -> view -> renderTemplate('templates/notifications');

	}
	
	function clearNotifications(){
		$this->model->clearNotifications();
	}
	
	function createNotification(){
		$this->model->createNotification();
	}

}
