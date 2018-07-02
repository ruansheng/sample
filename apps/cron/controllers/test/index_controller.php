<?php

class Test_Index_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $user = $this->base_ctx->rpc->user->sayHello(2);
        _dump($user);
    }

    public function demo() {
        $this->output['name'] = 'rs';
        $this->responseJson();
    }
}