<?php

class DB {
	private static $instance;

	public static function get() {
		if (!self::$instance) {
			self::$instance = new PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
		}

		return self::$instance;
	}
}
