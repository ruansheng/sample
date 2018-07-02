<?php

require BASE_DIR . '/rpc/config/config.php';

/**
 * Class Base_Rpc_ctx
 * @property Base_Rpc_Service_User $user
 */
class Base_Rpc_ctx {

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
        $this->lookup = new base_Rpc_Client_Lookup($addr);
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

<<<<<<< HEAD
        return new Base_Rpc_Client_Redis($config, $serviceAddr);
=======
    /**
     * @param $config
     * @return array
     */
    public function lookupSearchAddr($config) {
        //return ['172.16.20.163', 8628];
        return ['172.16.20.213', 8628];
>>>>>>> f8574cc977e01b02133e4f435d33c2d711312589
    }

}