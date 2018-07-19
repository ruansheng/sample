<?php

class Test_Index_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        sleep(1);
        _dump($this->get("a"));
        _dump($this->getAll());
        echo "crontab index method" . PHP_EOL;
    }
}