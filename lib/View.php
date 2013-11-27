<?php

require_once('csscrush/CssCrush.php');

class View {

	public $controller;
	public $styles = array();
	public $js = array();

	public function __construct($controller) {
		$this->controller = $controller;
		$this->addStylesheet("style.css");

		$this->base = Config::get('global', 'baseurl');
		$this->lang = Config::get('global', 'lang');

		$this->messages = Session::popMessages();
	}

	public function __get($name) {
		if (property_exists($this, $name)) {
			return $this->$name;
		} else {
			return '';
		}
	}

	public function addStylesheet($filename) {
		$this->styles[] = csscrush::tag(
			Config::get('global', 'cssdir') . $filename,
			array('debug' => false)
		);
	}

	public function pushMessage($message, $type=Message::INFO) {
		$this->messages[] = (object) array(
			'msg' => $message,
			'type' => $type
		);
	}

	public function render($action) {
		require("view/header.php");
		require("view/{$this->controller}/{$action}.php");
		require("view/footer.php");
	}

}