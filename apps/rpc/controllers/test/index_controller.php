<?php

class Test_Index_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function demo($a, $b) {
        $this->output['a'] = 1;
        $this->output['b'] = 2;
        $this->responseJson();
    }
}