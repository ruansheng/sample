<?php
/**
 * Class App
 * @property WebRouter $web_router
 * @property CronRouter $cron_router
 */
class App {
    static $instance = null;

    private function __construct(){}

    private function __clone(){}

    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __get($key) {
        if($key == 'web_router') {
            return new WebRouter();
        } else if ($key == 'cron_router') {
            return new CronRouter();
        }
        return null;
    }

    public function runApi($controller_path) {
        $router = $this->web_router->route();

        $file = $controller_path. $router['file'];

        if(!is_file($file)) {
            trigger_error($file . ' file not found', E_USER_NOTICE);
            exit(-1);
        }

        require $file;

        $controller = $router['controller'];
        $action = $router['action'];

        if(!class_exists($controller, false)) {
            trigger_error($file . ' controller not found', E_USER_NOTICE);
            exit(-1);
        }

        $controller_obj = new $controller();
        $controller_obj->$action();
    }

    public function runWeb($controller_path) {
        $router = $this->web_router->route();

        $file = $controller_path. $router['file'];

        if(!is_file($file)) {
            trigger_error($file . ' file not found', E_USER_NOTICE);
            exit(-1);
        }

        require $file;

        $controller = $router['controller'];
        $action = $router['action'];

        if(!class_exists($controller, false)) {
            trigger_error($file . ' controller not found', E_USER_NOTICE);
            exit(-1);
        }

        $controller_obj = new $controller();
        $controller_obj->$action();
    }

    public function runRpc($controller_path) {
        $router = $this->web_router->route();

        $file = $controller_path. $router['file'];

        if(!is_file($file)) {
            trigger_error($file . ' file not found', E_USER_NOTICE);
            exit(-1);
        }

        require $file;

        $controller = $router['controller'];
        $action = $router['action'];

        if(!class_exists($controller, false)) {
            trigger_error($file . ' controller not found', E_USER_NOTICE);
            exit(-1);
        }

        $controller_obj = new $controller();
        $controller_obj->$action();
    }

    public function runCron($controller_path) {
        $router = $this->cron_router->route();

        $file = $controller_path. $router['file'];

        if(!is_file($file)) {
            trigger_error($file . ' file not found', E_USER_NOTICE);
            exit(-1);
        }

        require $file;

        $controller = $router['controller'];
        $action = $router['action'];

        if(!class_exists($controller, false)) {
            trigger_error($file . ' controller not found', E_USER_NOTICE);
            exit(-1);
        }

        $controller_obj = new $controller();
        $controller_obj->file = $file;
        $controller_obj->method = $action;
        $controller_obj->start_time = microtime(true);
        $controller_obj->$action();
        $controller_obj->end_time = microtime(true);
        $info = "info";
        $controller_obj->$info();
    }
}