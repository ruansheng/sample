<?php

/**
 * Class Base_Controller
 */
class Base_Controller {

    protected $ctx;

    public $file;
    public $method;
    public $start_time;
    public $end_time;

    // cli argv
    public $params = [];

    /**
     * Base_Controller constructor.
     */
    public function __construct() {
        $this->ctx = Ctx::getInstance();
    }

    /**
     * @param $key
     * @param string $default
     * @return mixed
     */
    public function get($key, $default = '') {
        if(!isset($this->params[$key])) {
            return $default;
        }
        return $this->params[$key];
    }

    /**
     * @return mixed
     */
    public function getAll() {
        return $this->params;
    }

    /**
     * echo cron run info
     */
    public function info() {
        $memory_value = sprintf("%5.2f M", memory_get_peak_usage(true) / 1024 / 1024);
        $cost_time = sprintf("%5.3f S", ($this->end_time - $this->start_time));
        $hostname = gethostname();
        echo '--------------------------------------------------------------------------' . PHP_EOL;
        echo 'file: ' . $this->file . PHP_EOL;
        echo 'method: ' . $this->method . PHP_EOL;
        echo 'memory: ' . $memory_value . PHP_EOL;
        echo 'spend_time: ' . $cost_time . PHP_EOL;
        echo 'host: ' . $hostname . PHP_EOL;
        echo '--------------------------------------------------------------------------' . PHP_EOL;
    }
}