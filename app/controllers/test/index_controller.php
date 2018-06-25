<?php

class Test_Index_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        //$name = $this->ctx->user->manager_index->getTest();
        //var_dump($name);

        echo '<pre>';print_r($this->base_ctx->admin->manager_info);
        //$admin = $this->base_ctx->admin->manager_info->getInfo();
        //var_dump($admin);
    }
}