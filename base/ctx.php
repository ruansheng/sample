<?php

/**
 * Class Base_Ctx
 * @property Base_Admin_Ctx $admin
 */
class Base_Ctx extends Core_Ctx {
    public static $instance;

    public static function getInstance() {
        if(self::$instance == null) {
            self::$instance = new Base_Ctx();
        }
        return self::$instance;
    }

    public function getAdmin() {
        return new Base_Admin_Ctx($this);
    }
}