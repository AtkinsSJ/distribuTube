<?php

class Session {

	private static $_started = false;
	
	/**
	 * Starts the session. WIll only do so once per page load.
	 */
	private static function init() {
		if (!Session::$_started) {
			session_start() or die('Could not start session!');
			Session::$_started = true;
		}
	}

	/**
	 * Saves some data to the session.
	 */
	public static function set($key, $value) {
		if (!Session::$_started) {
			Session::init();
		}
		
		$_SESSION[$key] = $value;
	}
	
	/**
	 * Retrieves some data from the session, or returns false if not found.
	 */
	public static function get($key) {
		if (!Session::$_started) {
			Session::init();
		}
		
		if (isset($_SESSION[$key])) {
			return $_SESSION[$key];
		} else {
			return false;
		}
	}

	/**
	 * Clears the session.
	 */
	public static function destroy() {
		unset($_SESSION);
		session_destroy();
		Session::$_started = false;
	}
	
	/* ==
	 * Messages are pop-up messages you want to appear when the
	 * user next loads the page, for instance, login messages.
	 */
	
	/**
	 * Adds a message to the session.
	 */
	public static function pushMessage($message, $type='info') {
		$list = Session::get('messages');
		if (!is_array($list)) {
			$list = array();
		}
		$list[] = (object) array(
			'msg' => $message,
			'type' => $type
		);
		Session::set('messages', $list);
	}
	/**
	 * Retrieves and removes all messages from the session.
	 */
	public static function popMessages() {
		$list = Session::get('messages');
		if (!is_array($list)) {
			$list = array();
		}
		Session::set('messages', array());
		return $list;
	}
}