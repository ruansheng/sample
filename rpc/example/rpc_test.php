<?php

include_once '../autoload.php';

class Test {

    private $rpc;

    private $config = [
        'lookup' =>[
            'host' => '127.0.0.1',
            'port' => 6379,
            'timeout' => 0.3
        ]
    ];

    public function __construct(){
        $this->rpc = new Rpc_App_Ctx($this->config);
    }

    public function echoTest() {
        $this->rpc->user->sayHello(uniqid());
    }
}

$test = new Test();
$test->echoTest();