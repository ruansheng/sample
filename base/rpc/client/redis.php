<?php

class Base_Rpc_Client_Redis {

    private $timeout;
    private $service;
    private $interface;
    private $reflectClass;

    private $addr;

    public function __construct($config, $addr){
        $this->addr = $addr;

        $this->timeout = $config['timeout'];
        $this->service = $config['service'];
        $this->interface = $config['interface'];
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

        $cmd = $this->getCmd($this->service, $this->timeout, $args);

        $client = new Redis();
        if ($client->pconnect($this->addr[0], (int)$this->addr[1], (float)$this->timeout)) {
            trigger_error("morpc redis connect err:" . $this->service, E_USER_WARNING);
        }

        $ret = $client->get(json_encode($cmd));
        return $ret;
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