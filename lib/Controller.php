<?php

class Controller {

	protected $view;
	protected $user;

	public function __construct($name, $mustBeLoggedIn=false) {
		$this->user = new User();
		if ($this->user->isLoggedIn()) {
			Model::setUserId($this->user->getID());
		}

		if ($mustBeLoggedIn && !$this->user->isLoggedIn()) {
			Session::pushMessage('Your session has expired. Please log in.', Message::ERROR);
			redirect('login');
			die();
		}

		$this->view = new View($name);
		$this->view->user = $this->user;
		$this->view->loggedIn = $this->user->isLoggedIn();
	}
	
	public function render($action) {
		$this->view->render($action);
	}
	
}