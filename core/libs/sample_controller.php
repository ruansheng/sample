<?php
/**
 * Created by PhpStorm.
 * User: ruansheng
 * Date: 15/6/15
 * Time: 00:03
 */

class Sample_Controller {

    /**
     * @var array
     */
    private $trans = array();

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

    /**
     * __call
     * @param $action
     * @param $params
     */
    public function __call($action,$params) {
        $notice = 'notice :  "'.$action.'" method is not exists !'.PHP_EOL;
        errorTemplate($notice);
    }
}