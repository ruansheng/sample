<?php

/**
 * Class Autoloader
 */
class Autoloader {

    /**
     * @param $class
     * @return bool
     */
    public static function autoload($class) {
        $class = strtolower($class);
        $pos = explode('_', $class);
        array_shift($pos);
        $file = BASE_DIR . '/' . implode('/', $pos) . '.php';
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

    /**
     * registerAutoload
     */
    public static function registerAutoload() {
        spl_autoload_register("Autoloader::autoload");
    }

}