<?php

class Test_Index_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        sleep(3);
        echo "crontab index method" . PHP_EOL;
    }
}