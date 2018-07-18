<?php

/**
 * Class Base_Controller
 */
class Base_Controller {

    protected $ctx;
    protected $base_ctx;

    public $file;
    public $method;
    public $start_time;
    public $end_time;

    public function __construct() {
        $this->ctx = Ctx::getInstance();
        $this->base_ctx = Base_Ctx::getInstance();
    }

    public function info() {
        $memory_value = sprintf("%5.2f M", memory_get_peak_usage(true) / 1024 / 1024);
        $cost_time = sprintf("%5.3f S", ($this->end_time - $this->start_time));
        $hostname = gethostname();
        echo 'file: ' . $this->file . PHP_EOL;
        echo 'method: ' . $this->method . PHP_EOL;
        echo 'memory: ' . $memory_value . PHP_EOL;
        echo 'spend_time: ' . $cost_time . PHP_EOL;
        echo 'host: ' . $hostname . PHP_EOL;
    }
}