<?php

include($root_path . '/config.php');
include(__DIR__ . '/config.php');
Config::eat($config); // Feed $config to the static Config class

include(__DIR__ . '/constants.php');

include(__DIR__ . '/database.php');
include(__DIR__ . '/functions.php');

session_start();
include(__DIR__ . '/auth.php');
$auth = new Auth();

include(__DIR__ . '/template.php');
$template = new Template();
