<?php

class Bootstrap
{
	function __construct()
	{
		// Handle the URL
		$urlString = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($urlString, '/');
		$url = explode('/', $url);
		
		// If url is empty, go to the index
		if (empty($url[0])) {
			require('controller/index.php');
			$controller = new Index();
			$controller->index();
			return false;
		}
		
		// Attempt to open the given controller
		$file = "controller/{$url[0]}.php";
		if (file_exists($file))
		{
			require($file);
		}
		else
		{
			// Controller not found - use error controller
			require('controller/error.php');
			$controller = new Error();
			$controller->error404($urlString);
			return false;
		}

		$controller = new $url[0];

		if (isset($url[2]))
		{
			// Tell controller to display $url[1], with $url[2]... as args
			if (method_exists($controller, $url[1])) {
				call_user_func_array(
					array($controller, $url[1]),
					array_slice($url, 2)
				);
			} else {
				// Method not found - use error controller
				require('controller/error.php');
				$controller = new Error();
				$controller->error404($urlString);
				return false;
			}
		}
		elseif (isset($url[1]))
		{
			// Tell controller to display $url[1]
			if (method_exists($controller, $url[1])) {
				$controller->{$url[1]}();
			} else {
				// Method not found - use error controller
				require('controller/error.php');
				$controller = new Error();
				$controller->error404($urlString);
				return false;
			}
		}
		else
		{
			// By default go to index part
			$controller->index();
		}
	}
}