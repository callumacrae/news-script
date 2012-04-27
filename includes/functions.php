<?php

function get_var($name, $default = -1) {
	if ($default === -1) {
		return $_REQUEST[$name];
	} else if (!isset($_REQUEST[$name])) {
		return $default;
	}
	
	switch (gettype($default)) {
		case 'boolean':
			return (bool) $_REQUEST[$name];
			
		case 'integer':
			return (int) $_REQUEST[$name];
			
		case 'double':
			return (double) $_REQUEST[$name];

		case 'string':
			return (string) $_REQUEST[$name];

		case 'null':
			return null;
	}
}

function throw404() {
	global $template;
	header('HTTP/1.0 404 Not Found');
	$template->set_title('404: Page not found');
	$template->set_vars(array(
		'error'	=> '404: Page not found',
		'desc'	=> 'Perhaps you misspelt the URL or clicked a dodgy link?'
	));
	$template->parse('error');
}