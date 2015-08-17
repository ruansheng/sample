<?php
/**
 * Created by PhpStorm.
 * User: ruansheng
 * Date: 15/6/15
 * Time: 00:03
 */

/**
 * Class Sample_Controller
 */
class Sample_Controller extends Base{

    /**
     *
     * @param string $tmplate
     */
    public function display($tmplate = '') {

    }

    /**
     * echo Json
     * @param $data
     */
    public function echoJson($data) {
        header('Content-Type:text/json;charset=utf-8;');
        exit(json_encode($data));
    }
}