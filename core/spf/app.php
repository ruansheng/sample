<?php

/**
 * Class App
 */
class App {

    static $instance = null;

    /**
     * App constructor.
     */
    private function __construct(){

    }

    private function __clone(){

    }

    /**
     * @return App|null
     */
    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @param $config
     * @return bool
     */
    public function run($config) {
        if(!class_exists('App_Router')) {
            return false;
        }
        $router = new App_Router();
        $router->run($config);
        return true;
    }

}