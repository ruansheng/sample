<?php
/**
 * Created by PhpStorm.
 * User: ruansheng
 * Date: 2018/6/24
 * Time: 下午2:51
 */

class Router {
    public $controller = 'index';
    public $action = 'index';

    public function __construct(){}

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
            $controller = implode('_', $parts) . '_' . $controller . '_controller';
        } else {
            $file = $controller . '_controller.php';
            $controller = $controller . '_controller';
        }

        return [
            'uri' => $uri,
            'controller' => $controller,
            'action' => $action,
            'file' => $file
        ];
    }
}