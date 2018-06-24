
<?php
/**
 * Created by PhpStorm.
 * User: ruansheng
 * Date: 2018/6/24
 * Time: 下午2:41
 */

/**
 * Class App
 * @property Router $router
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
        if($key == 'router') {
            return new Router();
        }
        return null;
    }

    public function run($controller_path) {
        $router = $this->router->route();

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
}