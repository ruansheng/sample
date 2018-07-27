<?php
/**
 * Class Ctx
 * @property Base_Ctx $base
 * @property User_Ctx $user
 */
class Ctx extends Core_Ctx {
    public static $instance;

    public static function getInstance() {
        if(self::$instance == null) {
            self::$instance = new Ctx();
            spl_autoload_register('Ctx::autoload');
        }
        return self::$instance;
    }

    public static function autoload($class) {
        $class = strtolower($class);
        $file = __DIR__ . '/' . str_replace('_', '/', $class) . '.php';
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

    public function getBase() {
        return Base_Ctx::getInstance();
    }

    public function getUser() {
        return new User_Ctx($this);
    }
}