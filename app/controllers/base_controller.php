<?php

/**
 * Class Base_Controller
 */
class Base_Controller {

    protected $ctx;
    protected $base_ctx;

    public function __construct() {
        $this->ctx = Ctx::getInstance();
        $this->base_ctx = Base_Ctx::getInstance();
    }
}