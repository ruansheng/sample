<?php
/**
 * Created by PhpStorm.
 * User: ruansheng
 * Date: 15/6/9
 * Time: 23:09
 */

class index_controller extends Sample_Controller{

    public function __construct() {
    }

    public function index() {
        $this->echoJson(array('en'=>'200','em'=>'success'));
    }

}
