<?php
/**
 * Created by PhpStorm.
 * User: ruansheng
 * Date: 2018/6/24
 * Time: 下午4:35
 */

/**
 * Class User_Manager_Index
 * @property Ctx $ctx
 */
class User_Manager_Index {

    public function __construct($ctx){
        $this->ctx = $ctx;
    }

    public function getTest() {
        $name = 'hello world!';
        return $name;
    }
}