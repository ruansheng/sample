<?php
defined('RPC_CURRENT_DIR') || define('RPC_CURRENT_DIR', dirname(__FILE__));
defined('RPC_APP_DIR') || define('RPC_APP_DIR', dirname(__FILE__) . '/app');

include_once RPC_CURRENT_DIR . '/core/autoloader.php';
require_once RPC_APP_DIR . '/config/config.php';

// register autoload
Rpc_Core_Autoloader::registerAutoload();