<?php

/**
 * Class Config
 */
class Config {

    private $config = [];

    /**
     * @param  $filename
     * Request constructor.
     */
    public function __construct($filename){
        if(is_file($filename)) {
            $this->config = parse_ini_file($filename, true);
        }
    }

    /**
     * @return array
     */
    public function getAll() {
        return $this->config;
    }

    /**
     * @param $name
     * @return string
     */
    public function getSectionValues($name) {
        return isset($this->config[$name]) ? $this->config[$name] : [];
    }

    /**
     * @param $name
     * @param $key
     * @return array|bool
     */
    public function getSectionValue($name, $key) {
        if(!isset($this->config[$name])) {
            return "";
        }
        return isset($this->config[$name][$key]) ? $this->config[$name][$key] : "";
    }

}