<?php

class Database extends PDO {

	public $tablePrefix;

	function __construct() {
		$host = Config::get('database', 'host');
		$dbname = Config::get('database', 'dbname');
		$username = Config::get('database', 'username');
		$password = Config::get('database', 'password');
		
		$this->tablePrefix = Config::get('database', 'tableprefix');
		
		parent::__construct("mysql:host={$host};dbname={$dbname}", $username, $password);
	}
	
}

class DatabaseException extends Exception {
	public $query;
	public $errorInfo;

	public function __construct($message, $query, $errorInfo) {
		parent::__construct($message);
		$this->query = $query;
		$this->errorInfo = $errorInfo;
	}
}