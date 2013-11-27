<?php

class Video extends Controller {
	
	public function __construct() {
		parent::__construct('video');
	}

	public function watch($id) {

		$this->view->video = (object) Array(
			'id' => $id,
			'title' => 'Wildlife',
			'sources' => Array(
				'ogv' => 'videos/Wildlife.ogv'
			)
		);

		$this->view->title = 'Watching '. $id;

		$this->view->addRemoteStylesheet('//vjs.zencdn.net/4.2/video-js.css');
		$this->view->addScript('//vjs.zencdn.net/4.2/video.js');

		$this->render('watch');
	}
}