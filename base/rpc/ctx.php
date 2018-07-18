<?php

require BASE_DIR . '/rpc/config/config.php';

/**
 * Class Base_Rpc_ctx
 * @property Base_Rpc_Mode_Lookup $lookup
 * @property Base_Rpc_Mode_Direct $direct
 */
class Base_Rpc_ctx {


    protected $components;

    private $direct_config = [];
    private $lookup_config = [];

    /**
     * Rpc_App_Ctx constructor.
     * @param $config
     */
    public function __construct($config = []){
        $this->direct_config = isset($config['direct']) ? $config['direct'] : [];
        $this->lookup_config = isset($config['lookup']) ? $config['lookup'] : [];
    }

    /**
     * @param $key
     * @return Base_Rpc_Mode_Interface
     */
    public function __get($key){
        if(!isset($this->components[$key])) {
            if('direct' === $key) {
                $this->components[$key] = new Base_Rpc_Mode_Direct($this->direct_config);
            } else {
                $this->components[$key] = new Base_Rpc_Mode_Lookup($this->lookup_config);
            }
        }
        return $this->components[$key];
    }

}