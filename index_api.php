<?php

date_default_timezone_set('PRC');

// define vendor file
defined('VENDOR_AUTOLOAD_FILE') || define('VENDOR_AUTOLOAD_FILE', dirname(__FILE__) . '/vendor/autoload.php');

// define dirs
defined('COMMON_DIR') || define('COMMON_DIR', dirname(__FILE__) . '/common');
defined('CORE_DIR') || define('CORE_DIR', dirname(__FILE__) . '/core');
defined('BASE_DIR') || define('BASE_DIR', dirname(__FILE__) . '/base');
defined('APPS_DIR') || define('APPS_DIR', dirname(__FILE__) . '/apps');
defined('MODELS_DIR') || define('MODELS_DIR', dirname(__FILE__) . '/models');

// log collect file
$GLOBALS['log_file'] = '/var/log/php-fpm.log';
$vendor_file = '';

// require common
require_once COMMON_DIR . '/init.php';

// require packagist vendor
if(is_file(VENDOR_AUTOLOAD_FILE)) {
    require_once VENDOR_AUTOLOAD_FILE;
}

// require core
require_once CORE_DIR . '/init.php';

// require base
require_once BASE_DIR . '/init.php';

// require app
require_once APPS_DIR . '/api/init_api.php';

// require app models
require_once MODELS_DIR . '/ctx.php';

$controller_path = APPS_DIR . '/api/controllers/';
APP::getInstance()->runApi($controller_path);