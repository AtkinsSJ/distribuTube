<?php

class User {

	private $_loggedIn = false;
	
	private $_id = false;
	private $_username = false;
	private $_displayName = false;

	function __construct() {
		// If the user is saved to the session, load it.
		$attributes = Session::get('user');
		if ($attributes) {
			$attributes = unserialize($attributes);
			$this->_id = $attributes['id'];
			$this->_username = $attributes['username'];
			$this->_displayName = $attributes['display_name'];
			$this->_loggedIn  = true;
		}
	}
	
	/**
	 * Attempt to log-in. Returns whether sucessful.
	 */
	public function login($username, $password) {
	
		$db = new Database();
		$loginStmt = $db->prepare(
			"SELECT id, display_name, username FROM {$db->tablePrefix}users
			WHERE username = :username
				AND password = :password
			LIMIT 1"
		);
		
		$success = $loginStmt->execute( array(
			'username' => $username,
			'password' => md5($password)
		));
		
		if (!$success) {
			print_r($loginStmt->errorInfo());
		}
		
		if ($loginStmt->rowCount() > 0) {
			$this->_loggedIn = true;
			
			$row = $loginStmt->fetch(PDO::FETCH_ASSOC);
			
			$this->_id = $row['id'];
			$this->_displayName = $row['display_name'];
			$this->_username = $row['username'];
			
			return true;
		} else {
			// Failed login
			return false;
		}
	}
	
	/**
	 * Getters
	 */
	public function isLoggedIn() {
		return $this->_loggedIn;
	}
	public function getUsername() {
		if ($this->_loggedIn) {
			return $this->_username;
		} else {
			throw new Exception('Attempting to get username when not logged in.');
		}
	}
	public function getDisplayName() {
		if ($this->_loggedIn) {
			return $this->_displayName;
		} else {
			throw new Exception('Attempting to get user display name when not logged in.');
		}
	}
	public function getID() {
		if ($this->_loggedIn) {
			return $this->_id;
		} else {
			throw new Exception('Attempting to get user id when not logged in.');
		}
	}
	
	/**
	 * Log the user out and redirect to home page.
	 */
	public function logout() {
		Session::destroy();
		$this->_loggedIn = false;
	}
	
	public function __destruct() {
		// Save the user to the session if they are logged-in.
		if ($this->_loggedIn) {
			$this->_saveToSession();
		}
	}
	
	private function _saveToSession() {
		Session::set('user', serialize(
			array(
				'username' => $this->_username,
				'display_name' => $this->_displayName,
				'id' => $this->_id
			)
		));
	}
}