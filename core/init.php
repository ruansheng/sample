<?php

date_default_timezone_set('PRC');

// define vendor file
defined('VENDOR_AUTOLOAD_FILE') || define('VENDOR_AUTOLOAD_FILE', PRO_ROOT_DIR . '/vendor/autoload.php');

// define dirs
defined('COMMON_DIR') || define('COMMON_DIR', PRO_ROOT_DIR . '/common');
defined('CORE_DIR') || define('CORE_DIR', PRO_ROOT_DIR . '/core');
defined('BASE_DIR') || define('BASE_DIR', PRO_ROOT_DIR . '/base');
defined('APPS_DIR') || define('APPS_DIR', PRO_ROOT_DIR . '/apps');
defined('MODELS_DIR') || define('MODELS_DIR', PRO_ROOT_DIR . '/models');

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
require_once CORE_DIR . '/spf/autoloader.php';
require_once CORE_DIR . '/spf/ctx.php';
require_once CORE_DIR . '/spf/app.php';
require_once CORE_DIR . '/spf/router.php';
require_once CORE_DIR . '/spf/config.php';

// require base
require_once BASE_DIR . '/init.php';

// require app models
require_once MODELS_DIR . '/ctx.php';