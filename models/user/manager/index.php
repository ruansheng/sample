<?php

/**
 * Class User_Manager_Index
 * @property Ctx $ctx
 */
class User_Manager_Index {

    public function __construct($ctx){
        $this->ctx = $ctx;
    }

    public function getTest() {
        $name = $this->ctx->user->provider_index->getTest();
        return $name;
    }
}