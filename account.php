<?php

$root_path = __DIR__;
include('includes/common.php');

$conn = DB::get();

$mode = get_var('mode');

switch (strtolower($mode)) {
	case 'login':
		$template->set_title('Login');

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$user = get_var('user');
			$pass = get_var('pass');
			
			if ($user && $pass && $auth->login($user, $pass)) {
				$template->set_vars(array(
					'notice'	=> 'Successfully logged in',
					'desc'		=> '<a href="index.php">Return to index page</a>',
				));

				$template->parse('notice');
				break;
			}
			
			$template->set_vars(array(
				'error'	=> 'Failed to login.',
				'user'	=> $user
			));
		}

		$template->parse('login');
		break;
	
	case 'logout':
		$auth->logout();
		$template->set_vars(array(
			'notice'	=> 'Successfully logged out',
			'desc'		=> '<a href="index.php">Return to the index page</a>',
		));
		$template->set_title('Logout');
		$template->parse('notice');
		break;
	
	case 'register':
		$template->set_title('Register');

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$user = get_var('user');
			$pass = get_var('pass');
			$pass_confirm = get_var('pass_confirm');
			$email = get_var('email');
			
			$result = $auth->register($user, $pass, $pass_confirm, $email);
			if ($result === true) {
				$template->set_vars(array(
					'notice'	=> 'Successfully registered',
					'desc'		=> 'You may now <a href="account.php?mode=login">log in.</a>',
				));
				$template->parse('notice');
				break;
			}
			
			$template->set_vars(array(
				'error'		=> implode('<br />', $result),
				'user'		=> $user,
				'email'		=> $email,
			));
		}

		$template->parse('register');
		break;
	
	default:
		throw404();
		break;
}