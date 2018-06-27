<?php

/**
 * Class Request
 */
class Request {

    private $params = [];

    public function __construct(){
        $this->params = $_REQUEST;
    }

    /**
     * @return array
     */
    public function params() {
        return $this->params;
    }

    /**
     * @param $name
     * @param null $default
     * @return null
     */
    public function cookie($name, $default = null) {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $default;
    }

    /**
     * @param $name
     * @param string $default
     * @return string
     */
    public function get($name, $default = "") {
        return isset($this->params[$name]) ? $this->params[$name] : $default;
    }

    /**
     * @param $name
     * @param string $default
     * @return string
     */
    public function post($name, $default = "") {
        return isset($_POST[$name]) ? $_POST[$name] : $default;
    }

    /**
     * @param $name
     * @param int $default
     * @return string
     */
    public function int($name, $default = 0) {
        return isset($this->params[$name]) ? intval($this->params[$name]) : $default;
    }

    /**
     * @param $name
     * @param float $default
     * @return string
     */
    public function float($name, $default = 0.0) {
        return isset($this->params[$name]) ? floatval($this->params[$name]) : $default;
    }

    /**
     * @return bool
     */
    public function isAjax() {
        if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            return false;
        }
        if(strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === "xmlhttprequest") {
            return true;
        }
        return false;
    }

}