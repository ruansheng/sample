<?php

defined('PRO_ROOT_DIR') || define('PRO_ROOT_DIR', dirname(__FILE__));

// require core
require_once CORE_DIR . '/init.php';

// require app
require_once APPS_DIR . '/web/init_web.php';

$config = [
    'controller_path' => APPS_DIR . '/web/controllers/'
];
$flag = APP::getInstance()->run($config);

if(!$flag) {
    trigger_error('run error', E_USER_NOTICE);
    exit(-1);
}