<?php

/**
 * Class App
 * @property WebRouter  $web_router
 * @property WebRouter  $api_router
 * @property CronRouter $cron_router
 * @property RpcRouter  $rpc_router
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
     * @param $key
     * @return ApiRouter|CronRouter|null|RpcRouter|WebRouter
     */
    public function __get($key) {
        if($key == 'web_router') {
            return new WebRouter();
        } else if ($key == 'api_router') {
            return new ApiRouter();
        } else if ($key == 'cron_router') {
            return new CronRouter();
        } else if ($key == 'rpc_router') {
            return new RpcRouter();
        }
        return new WebRouter();
    }

    /**
     * @param $controller_path
     */
    public function runApi($controller_path) {
        if(!in_array(php_sapi_name(), ['cgi', 'cgi-fcgi'])) {
            trigger_error('run mode must is cgi or cgi-fcgi', E_USER_NOTICE);
            exit(-1);
        }

        $router = $this->api_router->route();

        $file = $router['file'];
        $controller = $router['controller'];
        $action = $router['action'];

        $file_path = $controller_path . $file;

        if(!is_file($file_path)) {
            trigger_error($file_path . ' file not found', E_USER_NOTICE);
            exit(-1);
        }

        require $file_path;

        if(!class_exists($controller, false)) {
            trigger_error($controller . ' controller not found', E_USER_NOTICE);
            exit(-1);
        }

        $controller_obj = new $controller();
        call_user_func([$controller_obj, $action]);
    }

    /**
     * @param $controller_path
     */
    public function runWeb($controller_path) {
        if(!in_array(php_sapi_name(), ['cgi', 'cgi-fcgi'])) {
            trigger_error('run mode must is cgi or cgi-fcgi', E_USER_NOTICE);
            exit(-1);
        }

        $router = $this->web_router->route();

        $file = $router['file'];
        $controller = $router['controller'];
        $action = $router['action'];

        $file_path = $controller_path . $file;

        if(!is_file($file_path)) {
            trigger_error($file_path . ' file not found', E_USER_NOTICE);
            exit(-1);
        }

        require $file_path;

        if(!class_exists($controller, false)) {
            trigger_error($controller . ' controller not found', E_USER_NOTICE);
            exit(-1);
        }

        $controller_obj = new $controller();
        call_user_func([$controller_obj, $action]);
    }

    /**
     * @param $controller_path
     */
    public function runRpc($controller_path) {
        $response = [
            'ec' => 401,
            'em' => "",
            'data' => []
        ];
        if(!in_array(php_sapi_name(), ['cgi', 'cgi-fcgi'])) {
            trigger_error('run mode must is cgi or cgi-fcgi', E_USER_NOTICE);
            $response['em'] = 'run mode must is cgi or cgi-fcgi';
            exit(json_encode($response));
        }

        $router = $this->rpc_router->route();

        $flag = $router['flag'];
        $file = $router['file'];
        $controller = $router['controller'];
        $action = $router['action'];
        $params = $router['params'];

        if(!$flag) {
            trigger_error('route parse error:' . $router['msg'], E_USER_NOTICE);
            $response['em'] = 'route parse error:' . $router['msg'];
            exit(json_encode($response));
        }

        $file_path = $controller_path . $file;

        if(!is_file($file_path)) {
            trigger_error($file_path . ' file not found', E_USER_NOTICE);
            $response['em'] = $file_path . ' file not found';
            exit(json_encode($response));
        }

        require $file_path;

        if(!class_exists($controller, false)) {
            trigger_error($controller . ' controller not found', E_USER_NOTICE);
            $response['em'] = $controller . ' controller not found';
            exit(json_encode($response));
        }

        // reflect
        $reflect_class = null;
        try {
            $reflect_class = new ReflectionClass($controller);
        } catch (Exception $e){
            trigger_error($controller . ' controller reflect fail:' . $e->getMessage(), E_USER_NOTICE);
            $response['em'] = $controller . ' controller reflect fail:' . $e->getMessage();
            exit(json_encode($response));
        }

        if(!$reflect_class->hasMethod($action)) {
            trigger_error($controller . ' class not exists method:' . $action, E_USER_NOTICE);
            $response['em'] = $controller . ' class not exists method:' . $action;
            exit(json_encode($response));
        }
        $reflect_method = $reflect_class->getMethod($action);
        $parameters = $reflect_method->getParameters();
        if(count($params) > count($parameters)) {
            trigger_error($controller . ' class not exists method:' . $action . ' params count error', E_USER_NOTICE);
            $response['em'] = $controller . ' class not exists method:' . $action . ' params count error';
            exit(json_encode($response));
        }

        $controller_obj = new $controller();
        $reflect_method->invokeArgs($controller_obj, $params);
    }

    /**
     * @param $controller_path
     */
    public function runCron($controller_path) {
        if(php_sapi_name() != 'cli') {
            trigger_error('run mode must is cli', E_USER_NOTICE);
            exit(-1);
        }

        $router = $this->cron_router->route();
        $file = $router['file'];
        $controller = $router['controller'];
        $action = $router['action'];
        $params = $router['params'];

        $file_path = $controller_path . $file;

        if(!is_file($file_path)) {
            trigger_error($file_path . ' file not found', E_USER_NOTICE);
            exit(-1);
        }

        require $file_path;

        if(!class_exists($controller, false)) {
            trigger_error($controller . ' controller not found', E_USER_NOTICE);
            exit(-1);
        }

        $controller_obj = new $controller();

        if(!method_exists($controller_obj, $action)) {
            trigger_error($controller . ' controller not exists method ' . $action, E_USER_NOTICE);
            exit(-1);
        }

        $controller_obj->params = $params;
        $controller_obj->file = $file;
        $controller_obj->method = $action;
        $controller_obj->start_time = microtime(true);
        call_user_func_array([$controller_obj, $action], []);
        $controller_obj->end_time = microtime(true);
        call_user_func([$controller_obj, "info"]);
    }

}