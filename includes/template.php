<?php

class Template {
	private $vars = array();

	public function set_var($index, $value) {
		$this->vars[$index] = $value;
	}

	public function set_vars($vars) {
		foreach ($vars as $index => $value) {
			$this->set_var($index, $value);
		}
	}

	public function parse($file_name) {
		// Include constants file here, as it may define variables
		include(Config::get('tmpl_path') . '/constants.php');

		extract($this->vars);
		$page_title = (isset($page_title) && $page_title !== '') ? ' &bull; ' . $page_title : '';
		include(Config::get('tmpl_path') . '/' . $file_name . TMPL_EXT);
	}

	// Alias functions:
	public function set_title($title = '') {
		$this->set_var('page_title', $title);
	}
}
