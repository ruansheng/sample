<?php

/**
 * Class Base_Ctx
 * @property Base_Admin_Ctx $admin
 * @property Base_Rpc_Ctx $rpc
 */
class Base_Ctx extends Core_Ctx {

    public static $instance;

    public static function getInstance() {
        if(self::$instance == null) {
            self::$instance = new Base_Ctx();
        }
        return self::$instance;
    }

    public function getAdmin() {
        return new Base_Admin_Ctx($this);
    }

    public function getRpc() {
        $config = [
            'lookup' =>[
                'host' => '127.0.0.1',
                'port' => 6379,
                'timeout' => 0.3
            ],
            'direct' => [
                'host' => '172.16.21.243',
                'port' => 8628,
                'timeout' => 0.3
            ],
        ];
        return new Base_Rpc_Ctx($config);
    }
}