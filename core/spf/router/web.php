<?php

/**
 * Class WebRouter
 */
class WebRouter {

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
}