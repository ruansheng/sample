<?php

/**
 * Class Rpc_App_Ctx
 * @property Rpc_App_Service_User $user
 */
class Rpc_App_Ctx {

    protected $services;
    protected $components;

    private $lookup;

    /**
     * Rpc_App_Ctx constructor.
     * @param $config
     */
    public function __construct($config = []){
        $this->services = $GLOBALS['rpc'];

        $addr = isset($config['lookup']) ? $config['lookup'] : [];
        $this->lookup = new Rpc_App_Client_Lookup($addr);
    }

    /**
     * @param $key
     * @return Rpc_App_Client_Redis
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
     * @return Rpc_App_Client_Redis
     */
    private function getClient($key) {
        $config = $this->services[$key];

        $serviceAddr = $this->lookup->request($config);
        if(!isset($serviceAddr['host']) || !isset($serviceAddr['port'])) {
            return null;
        }

        return new Rpc_App_Client_Redis($config, $serviceAddr);
    }

}