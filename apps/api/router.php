<?php
class App_Router implements Router {

    public $controller = 'index';
    public $action = 'index';

    /**
     * @return string
     */
    private function parseUri() {
        $request_uri = $_SERVER['REQUEST_URI'];
        $pos = strpos($request_uri, '?');
        if($pos != false) {
            $uri = substr($request_uri, 0 , $pos);
        } else {
            $uri = $request_uri;
        }
        return trim($uri, '/');
    }

    /**
     * @return array
     */
    public function route() {
        $uri = $this->parseUri();
        $parts = empty($uri) ? [] : explode('/', $uri);

        if(count($parts) >= 2) {
            $action = array_pop($parts);
            $controller = array_pop($parts);
        } else {
            $action = $this->action;
            $controller = $this->controller;
        }

        if(count($parts) > 0) {
            $file = implode('/', $parts) . '/' . $controller . '_controller.php';
            $partsArray = array_map(function ($v){
                return ucfirst($v);
            }, $parts);
            $controller = implode('_', $partsArray) . '_' . ucfirst($controller) . '_Controller';
        } else {
            $file = $controller . '_controller.php';
            $controller = ucfirst($controller) . '_Controller';
        }

        return [
            'uri' => $uri,
            'controller' => $controller,
            'action' => $action,
            'file' => $file
        ];
    }

    public function run($config) {
        if(!in_array(php_sapi_name(), ['cgi', 'cgi-fcgi'])) {
            trigger_error('run mode must is cgi or cgi-fcgi', E_USER_NOTICE);
            exit(-1);
        }

        $controller_path = isset($config['controller_path']) ? $config['controller_path'] : '';
        if(empty($controller_path)) {
            trigger_error('controller_path is empty', E_USER_NOTICE);
            exit(-1);
        }

        $router = $this->route();

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

}