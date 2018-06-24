<?php

class Autoloader {

    public static function autoload($class) {
        $class = strtolower($class);
        $file = BASE_DIR . '/' . str_replace('_', '/', $class) . '.php';
        if(is_file($file)) {
            require $file;
        }
        return class_exists($class, false) || interface_exists($class, false);
    }

    public static function registerAutoload() {
        spl_autoload_register("Autoloader::autoload");
    }

}