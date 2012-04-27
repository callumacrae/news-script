<?php

class Auth {
	private $conn;
	public $logged;
	public $info;
	public $uid;

	public function __construct() {
		$this->conn = DB::get();

		if (isset($_SESSION['logged']) && $_SESSION['logged'] && !empty($_SESSION['uid']) && !empty($_COOKIE['d2p_s'])) {
			$sql = 'SELECT * FROM ' . USERS_TABLE . ' WHERE ip = ? AND cookie = ? AND id = ?';
			$statement = $this->conn->prepare($sql);
			$statement->execute(array($_SERVER['REMOTE_ADDR'], $_COOKIE['d2p_s'], $_SESSION['uid']));
			$result = $statement->fetchObject();

			if (is_object($result)) {
				$this->logged = true;
				$this->uid = $result->id;
				$this->info = $result;
			} else {
				$this->logout();
			}
		}
	}

	private function hash() {
		$args = func_get_args();
		$end = '';
		foreach ($args as $arg) {
			$end = sha1($end . sha1($arg));
		}
		return $end;
	}

	public function login($user, $pass) {
		$sql = 'SELECT * FROM ' . USERS_TABLE . ' WHERE user = ? AND pass = ?';
		$statement = $this->conn->prepare($sql);
		$statement->execute(array($user, $this->hash($user, $pass)));

		$result = $statement->fetchObject();

		if (is_object($result)) {
			$this->logged = $_SESSION['logged'] = true;
			$this->uid = $_SESSION['uid'] = $result->id;
			$this->info = $result;

			$cookie = md5(uniqid(rand(), true));
			setcookie('d2p_s', $cookie);

			$sql = 'UPDATE ' . USERS_TABLE . ' SET ip = ?, cookie = ? WHERE id = ?';
			$statement = $this->conn->prepare($sql);
			$statement->execute(array($_SERVER['REMOTE_ADDR'], $cookie, $result->id));

			return true;
		} else {
			return false;
		}
	}

	public function logout() {
		$sql = 'UPDATE ' . USERS_TABLE . ' SET ip = NULL AND cookie = NULL WHERE id = ?';
		$statement = $this->conn->prepare($sql);
		$statement->execute(array($_SESSION['uid']));

		setcookie('d2p_s', $cookie, time() - 3600);

		session_destroy();
	}

	public function register($username, $password, $pass_confirm, $email) {
		$result = array();
		if (strlen($username) < 3) {
			$result[] = 'Username too short.';
		}
		if (strlen($username) > 20) {
			$result[] = 'Username too long.';
		}
		if ($password !== $pass_confirm) {
			$result[] = 'Passwords do not match.';
		}
		if (strlen($password) < 6) {
			$result[] = 'Password too short.';
		}
		if (strlen($password) > 120) {
			$result[] = 'Password too long.';
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$result[] = 'Email address is invalid.';
		}

		$statement = $this->conn->prepare('SELECT user FROM ' . USERS_TABLE . ' WHERE user = ?');
		$statement->execute(array($username));
		if (is_object($statement->fetchObject())) {
			$result[] = 'Username already taken.';
		}

		$statement = $this->conn->prepare('SELECT email FROM ' . USERS_TABLE . ' WHERE email = ?');
		$statement->execute(array($email));
		if (is_object($statement->fetchObject())) {
			$result[] = 'Email already taken.';
		}

		if (!empty($result)) {
			return $result;
		}

		$sql = 'INSERT INTO ' . USERS_TABLE . ' (user, pass, email, date) VALUE (?, ?, ?, ?)';
		$statement = $this->conn->prepare($sql);
		$statement->execute(array($username, $this->hash($username, $password), $email, time()));

		$uid = $this->conn->lastInsertId();

		$subject = 'Registration at dota2pros';
		$message = <<< EOF
Hi $username.

Thanks for registering. Your username is "$username".

A couple links you might find useful:
Direct login link: http://.../account.php?mode=login

---
dota2pros
EOF;

		$phpversion = phpversion();
		$headers = <<< EOF
From: {$config['email']}
X-Mailer: PHP/$phpversion
EOF;

		mail($email, $subject, $message, $headers);

		return intval($uid);
	}
}
