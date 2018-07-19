<?php

/**
 * Class RpcRouter
 */
class RpcRouter {

    private $services;

    public function __construct(){
        $this->services = $GLOBALS['services'];
    }

    private function parseArgv() {
        // parse rpc params
        $input_data = file_get_contents('php://input', 'r');
        $input = json_decode($input_data, true);

        $service = $input['service'];   //    test_index
        $method  = $input['method'];
        $args    = $input['args'];

        if(!array_key_exists($service, $this->services)) {
            return [];
        }

        $service_array = $this->services[$service];
        $interface = $service_array['interface'];
        if(strpos($interface, "/") === false) {
            return [];
        }

        // file
        $file = '/' . $interface . '_controller.php';
        $action = $method;
        $params = $args;

        // controlelr
        $parts = explode("/", $interface);
        $parts = array_map(function ($v){
            return ucfirst($v);
        }, $parts);
        $controller = implode('_', $parts) . '_Controller';

        $router = [
            'file' => $file,
            'controller' => $controller,
            'action' => $action,
            'params' => $params
        ];
        return $router;
    }

    public function route() {
        $router = $this->parseArgv();
        return $router;
    }
}