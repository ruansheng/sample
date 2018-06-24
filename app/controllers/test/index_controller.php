<?php
/**
 * Created by PhpStorm.
 * User: ruansheng
 * Date: 2018/6/24
 * Time: 下午3:26
 */

class Test_Index_Controller extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $name = $this->ctx->user->manager_index->getTest();
        var_dump($name);
    }
}