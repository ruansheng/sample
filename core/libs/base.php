<?php
/**
 * 
 * @author ruansheng
 * @since  2015-08-17
 */

/**
 * Base
 * Class Base
 */
class Base {

    /**
     * error no
     * @var int
     */
    public $no = 0;

    /**
     * error msg
     * @var string
     */
    public $msg = '';

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