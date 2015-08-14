<?php
/**
 * Created by PhpStorm.
 * User: ruansheng
 * Date: 15/6/9
 * Time: 22:03
 */
class Request {

    /**
     * Filter type
     * @var array
     */
    static private $filter = array(
        'htmlentities',
        'addslashes'
    );

    /**
     * HTTP GET
     * @param $key
     * @param string $default
     * @return array
     */
    public static function get($key='', $default = '') {
        if($key == '') {
            $tmp = self::_filter($_GET);
        } else {
            $tmp =  self::_filter($_GET[$key]);
        }

        if(!empty($default)) {
            if(empty($tmp)) {
                $tmp = $default;
            }
        }
        return $tmp;
    }

    /**
     * HTTP POST
     * @param $key
     * @param string $default
     * @return array
     */
    public static function post($key='', $default = '') {
        if($key == '') {
            $tmp = self::_filter($_POST);
        } else {
            $tmp = self::_filter($_POST[$key]);
        }

        if(!empty($default)) {
            if(empty($tmp)) {
                $tmp = $default;
            }
        }
        return $tmp;
    }

    /**
     * Filter
     * @param $data
     * @return string
     */
    private static function _filter($data) {
        $tmp = '';
        if(!empty($data)){
            if(empty(self::$filter)) {
                $tmp = $data;
            } else {
                foreach(self::$filter as $filter) {
                    if(is_array($data)) {
                        $tmp = self::_loopFilter($data);
                    } else {
                        $tmp = $filter($data);
                    }
                }
            }
        }
        return $tmp;
    }

    /**
     * loop filter
     * @param $data
     * @return array
     */
    private static function _loopFilter($data) {
        $tmp = array();
        foreach($data as $key => $i) {
            if(is_array($i)) {
                $tmp[$key] = self::_loopFilter($i);
            } else {
                $tmp[$key] = $i;
            }
        }
        return $tmp;
    }

}