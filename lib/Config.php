<?php

/**
 * Config class
 *
 * Provides access to config.ini
 */
class Config {
	private static $config = null;
	private static $db = null;
	
	public static function init() {
		if (Config::$config == null) {
			// Get ini settings
			Config::$config = parse_ini_file('config/config.ini', true);
		
			// Create db object
			Config::$db = new Database();
			
			// Get database settings
		/*	$user = new User();
			if ($user->isLoggedIn()){
				Config::_loadUserSettings($user->getID());
			}*/
		}
	}
	
	/**
	 * Load all the user's settings from the database.
	 */
	/*private static function _loadUserSettings($userid) {
		$db = Config::$db;
		$statement = $db->prepare(
			"SELECT * FROM {$db->tablePrefix}configuration
			WHERE userid = :userid"
		);
		
		if ($statement->execute( array(
			'userid' => $userid
		))) {
			while ($row = $statement->fetchObject()) {
				Config::$config['user'][$row->name] = $row->value;
			}
		}
	}*/
	
	/**
	 * Save the user's $settings (array of name => value) to the DB.
	 */
	/*public static function saveUserSettings($userid, $settings) {
		$db = Config::$db;
		$statement = $db->prepare(
			"INSERT INTO {$db->tablePrefix}configuration
				(userid, name, value)
			VALUES (:userid, :name, :value)
			ON DUPLICATE KEY UPDATE value = :value"
			
		);
		
		foreach ($settings as $name => $value) {
			if ( $statement->execute( array(
						'userid' => $userid,
						'name' => $name,
						'value' => $value
					)
				)
			) {
				// It went ok!
				// Update config variable
				Config::$config['user'][$name] = $value;
			} else {
				// Something went wrong!
				echo 'fail!';
				return false;
			}
		}
		
		return true;
	}*/
	
	/**
	 * Returns the value of $variable from the [$section] section
	 */
	public static function get($section, $variable) {
		Config::init();
		return @Config::$config[$section][$variable];
	}
	
	/**
	 * Returns all settings within the [$section] setcion
	 */
	public static function getSection($section) {
		Config::init();
		return @Config::$config[$section];
	}
	
	/**
	 * Set a temporary config variable for this page request.
	 *
	 * These variables will be held in the 'temp' namespace
	 */
	public static function setTemporary($variable, $value) {
		Config::init();
		Config::$config['temp'][$variable] = $value;
	}
}
