<?php

/**
 * Class User_Provider_Index
 * @property Ctx $ctx
 */
class User_Provider_Index {

    public function __construct($ctx){
        $this->ctx = $ctx;
    }

    public function getTest() {
        $name = 'hello world provider!';
        return $name;
    }
}