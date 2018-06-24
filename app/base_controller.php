<?php

class Base_Controller {

    protected $ctx;

    public function __construct() {
        require_once CORE_DIR . '/ctx.php';
        require_once APP_DIR . '/models/ctx.php';
        $this->ctx = Ctx::getInstance();
    }
}