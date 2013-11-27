<?php

function autoload($className) {
	include( "lib/{$className}.php" );
}
spl_autoload_register('autoload');

function redirect($page) {
	$baseUrl = Config::get('global', 'baseurl');
	header("location: {$baseUrl}{$page}");
	die();
}

abstract class Message {
	const INFO = 'info';
	const ERROR = 'error';
	const SUCCESS = 'success';
}

$app = new BootStrap();