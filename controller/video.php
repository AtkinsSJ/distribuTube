<?php

class Video extends Controller {
	
	public function __construct() {
		parent::__construct('video');
	}

	public function watch($id) {

		$this->view->video = (object) Array('id' => $id);

		$this->view->title = 'Watching '. $id;

		$this->render('watch');
	}
}