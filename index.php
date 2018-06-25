<?php

date_default_timezone_set('PRC');

defined('BASE_DIR') || define('BASE_DIR', dirname(__FILE__) . '/base');
defined('CORE_DIR') || define('CORE_DIR', dirname(__FILE__) . '/core');
defined('APP_DIR') || define('APP_DIR', dirname(__FILE__) . '/app');

// require core
require CORE_DIR . '/init.php';

// require base
require BASE_DIR . '/init.php';

// require app
require APP_DIR . '/init.php';

$controller_path = APP_DIR . '/controllers/';
APP::getInstance()->run($controller_path);