<?php
/**
 * Created by PhpStorm.
 * User: ruansheng
 * Date: 2018/6/24
 * Time: 下午3:10
 */

/**
 * Class Ctx
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

        return class_exists($class, false) || interface_exists($class, false);
    }

    public function getUser() {
        return new User_Ctx($this);
    }
}