<?php

require BASE_DIR . '/rpc/config/config.php';

/**
 * Class Base_Rpc_ctx
 * @property Base_Rpc_Service_User $user
 */
class Base_Rpc_ctx extends Core_Ctx {

    /**
     * @var Base_Ctx
     */
    protected $ctx;

    protected $services;

    protected $components;

    public function __construct($ctx){
        $this->ctx = $ctx;
        parent::__construct($ctx);
        $this->services = $GLOBALS['rpc'];
    }

    public function __get($key){
        if(!array_key_exists($key, $this->services)) {
            return null;
        }
        if(!isset($this->components[$key])) {
            $this->component[$key] = $this->getClient($key);
        }
        return $this->component[$key];
    }

    /**
     * @param $key
     * @return Base_Rpc_Client_Redis
     */
    public function getClient($key) {
        $config = $this->services[$key];

        // lookup search rpc addr
        $addr = $this->lookupSearchAddr($config);

        // return client
        return new Base_Rpc_Client_Redis($config, $addr);
    }

    /**
     * @param $config
     * @return array
     */
    public function lookupSearchAddr($config) {
        return ['172.16.20.163', 8628];
    }

}