<?php

/**
 * Class Rpc_Core_Autoloader
 */
class Rpc_Core_Autoloader {

    public static function autoload($class) {
        $class = strtolower($class);
        $pos = explode('_', $class);
        array_shift($pos);
        $file = RPC_CURRENT_DIR . '/' . implode('/', $pos) . '.php';
        if(is_file($file)) {
            require_once $file;
        }
        if(class_exists($class, false)) {
            return true;
        }
        if(interface_exists($class, false)) {
            return true;
        }
        return false;
    }

    public static function registerAutoload() {
        spl_autoload_register("Rpc_Core_Autoloader::autoload");
    }

}