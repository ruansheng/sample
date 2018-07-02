<?php

/**
 * Class Rpc_App_Client_Lookup
 */
class Base_Rpc_Client_Lookup {

    private $host;
    private $port;
    private $timeout = 0.2;

    /**
     * Rpc_App_Client_Lookup constructor.
     * @param array $addr
     */
    public function __construct($addr = []){
        if(isset($addr['host']) && $addr['host']) {
            $this->host = $addr['host'];
        }
        if(isset($addr['port']) && $addr['port']) {
            $this->port = $addr['port'];
        }
        if(isset($addr['timeout']) && $addr['timeout']) {
            $this->timeout = $addr['timeout'];
        }
    }

    /**
     * @param $config
     * @return array ['host' => '', 'port' => ]
     */
    public function request($config) {
        if(!isset($config['service']) || empty($config['service'])) {
            return [];
        }

        $service = $config['service'];

        // build cmd
        $args = ['service' => $service];
        $cmd = $this->getCmd('/service/lookup', 'getService', $args);

        // call lookup
        $result = [];
        try {
            $client = new Redis();
            if ($client->pconnect($this->host, intval($this->port), floatval($this->timeout))) {
                $error_str = sprintf("rpc lookup connect err:%s (%s:%d)", $service, $this->host, $this->port);
                trigger_error($error_str, E_USER_WARNING);
                return [];
            }

            $ret = $client->get(json_encode($cmd));
            $result  = $ret ? json_decode($ret, true) : [];
        } catch(Exception $e) {
            $error_str = sprintf("rpc lookup redis call err:%s (%s)", $e->getMessage(), $service);
            trigger_error($error_str, E_USER_WARNING);
        }

        if(empty($result) || !isset($result['ec']) || $result['ec'] != 200) {
            return [];
        }

        return isset($ret['data']) ? $ret['data'] : null;
    }

    /**
     * @param $service
     * @param $method
     * @param $args
     * @return array
     */
    private function getCmd($service, $method, $args) {
        $cmd = [
            'rid' => uniqid(),
            'service' => $service,
            'method' => $method,
            'args' => $args
        ];
        return $cmd;
    }

}