<?php

define('TMPL_EXT', '.php');

define('HEADER', 'header' . TMPL_EXT);
define('FOOTER', 'footer' . TMPL_EXT);


// Actual template settings
global $auth, $template;
$template->set_vars(array(
	'responsive'	=> false,
	'logged'		=> $auth->logged,

	'username'		=> $auth->info->user,
	'userid'		=> $auth->uid,
));
