<?php

class Database extends PDO {
	
	public function __construct() {
		parent::__construct('mysql:host=localhost;dbname=cake_php_db','root','');
	}
}
