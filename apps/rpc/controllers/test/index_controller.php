<?php

class Test_Index_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function demo() {
        $this->output['name'] = 'rs';
        $this->responseJson();
    }
}