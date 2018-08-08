<?php

class Test_Index_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $user = $this->ctx->base->rpc->user->sayHello(2);
        _dump($user);
    }

    public function demo() {
        $this->output['name'] = 'rs';
        $this->responseJson();
    }

    public function config() {
        $config = new Config(CONFIG_DIR . '/local.ini');
        $array = $config->getAll();
        _dump($array);
    }

    public function view() {
        $name = $this->ctx->user->manager_index->getTest();
        $this->output['name'] = $name;
        $this->display('test/index/view.html');
    }
}