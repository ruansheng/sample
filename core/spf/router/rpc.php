<?php

/**
 * Class RpcRouter
 */
class RpcRouter {

    private $services;

    public function __construct(){
        $this->services = $GLOBALS['services'];
    }

    /**
     * @param $input array
     * @return array
     */
    private function parseArgv($input) {
        $rid = isset($input['rid']) ? $input['rid'] : '';               //    request id
        $service = isset($input['service']) ? $input['service'] : '';   //    request service
        $method  = isset($input['method']) ? $input['method'] : '';
        $args    = isset($input['args']) ? $input['args'] : [];

        $router = [
            'flag' => false,
            'file' => '',
            'controller' => '',
            'action' => '',
            'params' => [],
            'msg' => ''
        ];

        if(empty($rid)) {
            $router['msg'] = 'rid is empty';
            return $router;
        }

        if(empty($service)) {
            $router['msg'] = 'service is empty';
            return $router;
        }

        if(empty($method)) {
            $router['msg'] = sprintf("'%s' service: '%s' method is empty", $service, $method);
            return $router;
        }

        // service config
        if(!array_key_exists($service, $this->services)) {
            $router['msg'] = sprintf("'%s' service not exists", $service);
            return $router;
        }

        $config = $this->services[$service];
        $interface = isset($config['interface']) ? $config['interface'] : '';
        if(empty($interface) || strpos($interface, "/") === false) {
            $router['msg'] = sprintf("%s service interface is error", $service);
            return $router;
        }

        // controlelr
        $parts = explode("/", $interface);
        $parts = array_map(function($v) {
            return ucfirst($v);
        }, $parts);

        // parse success
        $router['flag'] = true;
        $router['file'] = sprintf('/%s_controller.php', $interface);                   // example:   /test/index_controller.php
        $router['controller'] = sprintf('%s_Controller', implode('_', $parts));  // example:   Test_Index_Controller.php
        $router['action'] = $method;
        $router['params'] = $args;

        return $router;
    }

    public function route() {
        // parse rpc params
        $input_data = file_get_contents('php://input', 'r');
        $input = json_decode($input_data, true);

        $input = [
            'rid' => 'xxx',
            'service' => 'test',
            'method' => 'demo',
            'args' => [1,2],
        ];

        $router = $this->parseArgv($input);
        return $router;
    }
}