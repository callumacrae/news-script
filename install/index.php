<?php

/**
 * callumacrae/news-script
 *
 * @author Callum Macrae <callum@macr.ae>
 * @license http://sam.zoy.org/wtfpl/ Do What The Fuck You Want To Public License
 */

$errors = false;

if (!is_readable(__DIR__ . '/../config.php')) {
	echo 'Error: config.php does not exist or is not readable.' . PHP_EOL;
	$errors = true;
}

if (version_compare(PHP_VERSION, '5.3.0', '<')) {
	echo 'Unsupported version of PHP, please upgrade to at least 5.3 (you are using ' . PHP_VERSION . ').' . PHP_EOL;
	$errors = true;
}

if ($errors) {
	exit;
}

$root_path = __DIR__ . '/..';
include($root_path . '/includes/common.php');

$step = get_var('step', 0);
Config::override('tmpl_path', __DIR__ . '/template');
$template->set_title('Install');

if ($step === 0) {
	$template->parse('install');
} else if ($step === 1) {
	$conn = DB::get();

	$sql = 'CREATE TABLE IF NOT EXISTS ' . USERS_TABLE . ' (
		id int(11) NOT NULL AUTO_INCREMENT,
		user varchar(40) NOT NULL,
		pass varchar(120) NOT NULL,
		email varchar(120) NOT NULL,
		date int(11) NOT NULL,
		role int(11) DEFAULT 0,
		ip varchar(40),
		cookie varchar(40),

		PRIMARY KEY (id),
		UNIQUE KEY user (user, email)
	);';
	$conn->query($sql);

	$user = get_var('user', '');
	$pass = get_var('pass', '');
	$pass_confirm = get_var('pass_confirm');
	$email = get_var('email', '');

	$result = $auth->register($user, $pass, $pass_confirm, $email);
	if (!is_int($result)) {
		var_dump($result, is_int($result));
		$template->set_vars(array(
			'error'		=> implode('<br />', $result),
			'user'		=> $user,
			'email'		=> $email,
		));
		$template->parse('install');
	} else {
		$sql = 'UPDATE ' . USERS_TABLE . ' SET role = 10 WHERE id = ' . (int) $result;
		$conn->query($sql);

		$template->set_vars(array(
			'notice'	=> 'Successfully installed board',
			'desc'		=> 'You may now <a href="../account.php?mode=login">log in.</a> Remember to delete the install directory.',
		));

		$template->parse('notice');
	}
}
