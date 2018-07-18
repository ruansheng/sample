<?php

class Test_Index_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        _dump($this->base_ctx->rpc->lookup->test);
        $user = $this->base_ctx->rpc->lookup->test->sayHello(2);
        var_dump($user);
    }

    public function demo() {
        $this->output['name'] = 'rs';
        $this->responseJson();
    }
}