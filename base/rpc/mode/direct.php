<?php
/**
 * @property  Base_Rpc_Service_Test $test
 */
class Base_Rpc_Mode_Direct implements Base_Rpc_Mode_Interface {

    protected $services;
    protected $components;

    private $service_addr = [];

    /**
     * Rpc_App_Ctx constructor.
     * @param $config
     */
    public function __construct($config = []){
        $this->services = $GLOBALS['rpc'];

        $this->service_addr = $config;
    }

    /**
     * @param $key
     * @return Base_Rpc_Client_Redis
     */
    public function __get($key){
        if(!array_key_exists($key, $this->services)) {
            return null;
        }
        if(!isset($this->components[$key])) {
            $this->components[$key] = $this->getClient($key);
        }
        return $this->components[$key];
    }

    /**
     * @param $key
     * @return Base_Rpc_Client_Redis
     */
    private function getClient($key) {
        $service_config = $this->services[$key];

        return new Base_Rpc_Client_Redis($service_config, $this->service_addr);
    }
}