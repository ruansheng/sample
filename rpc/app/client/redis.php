<?php

class Rpc_App_Client_Redis {

    private $timeout = 0.2;
    private $service;
    private $interface;
    private $reflectClass;

    private $addr;

    public function __construct($config, $addr){
        $this->addr = $addr;

        $this->timeout = isset($config['timeout']) ? $config['timeout'] : 0.2;
        $this->service = isset($config['service']) ? $config['service'] : '';
        $this->interface = isset($config['interface']) ? $config['interface'] : '';

        $this->reflectClass = new ReflectionClass($this->interface);
    }

    /**
     * @param $methodName
     * @param $arguments
     * @return null
     */
    public function __call($methodName, $arguments){
        $method = $this->reflectClass->getMethod($methodName);
        $parameters = $method->getParameters();

        if(count($arguments) != count($parameters)) {
            trigger_error(sprintf("%s->%s args count error", $this->interface, $methodName));
            return null;
        }

        $args = [];
        for($i = 0; $i < count($parameters); $i++) {
            $key = $parameters[$i]->getName();
            $args[$key] = $arguments[$i];
        }

        $cmd = $this->getCmd($this->service, $methodName, $args);

        $result = null;
        try {
            $client = new Redis();
            if ($client->pconnect($this->addr['host'], (int)$this->addr['port'], (float)$this->timeout)) {
                $error_str = sprintf("rpc redis connect err:%s (%s:%d)", $this->service, $this->addr['host'], $this->addr['port'], $this->service);
                trigger_error($error_str, E_USER_WARNING);
            }

            $ret = $client->get(json_encode($cmd));
            $result  = $ret ? json_decode($ret, true) : null;
        } catch(Exception $e) {
            $error_str = sprintf("rpc redis call err:%s (%s)", $e->getMessage(), $this->service);
            trigger_error($error_str, E_USER_WARNING);
        }

        if(empty($result) || !isset($ret['ec']) || $ret['ec'] != 200) {
            return null;
        }

        return isset($ret['data']) ? $ret['data'] : [];
    }

    public function getCmd($service, $method, $args) {
        $cmd = [
            'rid' => uniqid(),
            'service' => $service,
            'method' => $method,
            'args' => $args
        ];
        return $cmd;
    }
}