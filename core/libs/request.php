<?php
/**
 * Created by PhpStorm.
 * User: ruansheng
 * Date: 15/6/9
 * Time: 22:03
 */

class Request {

    /**
     * get HTTP param
     * @param string $key
     * @return mixed
     */
    public static function get($key= '') {
        if(empty($key)) {
            return $_REQUEST;
        } else {
            return $_REQUEST[$key];
        }
    }

}