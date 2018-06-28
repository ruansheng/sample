<?php

class Test_Index_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        //$name = $this->ctx->user->manager_index->getTest();
        //var_dump($name);

        /*
        $admin = $this->base_ctx->admin->manager_info->getInfo();
        var_dump($admin);
        _dump($admin);
        */

        //_dump($this->base_ctx->rpc);

        for($i = 0; $i < 1; $i++) {
            //$s = microtime(true) * 1000;
            $user = $this->base_ctx->rpc->user->sayHello(2);
            $e = microtime(true) * 1000;

            //$b = $e - $s;
            //var_dump($b);
            //_dump($user);
            //sleep(2);
        }
    }

    public function demo() {
        $this->output['name'] = 'rs';
        $this->responseJson();
    }
}