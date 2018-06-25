<?php

/**
 * Class Core_Ctx
 */
class Core_Ctx {

    protected $component = [];
    protected $prefix = '';

    public function __construct($ctx = null){
        $class = get_class($this);
        if(!$this->prefix) {
            $pos = strpos($class, '_');
            if($pos !== false) {
                $this->prefix = substr($class, 0, $pos + 1);
            }
        }
    }

    public function __get($key) {
        if(!isset($this->component[$key])) {
            $func = 'get' . $key;
            if(method_exists($this, $func)) {
                $this->component[$key] = $this->$func();
            } else {
                $class = $this->prefix . $key;
                if(class_exists($class)) {
                    $this->component[$key] = new $class($this);
                } else {
                    trigger_error(get_class($this) . ' key: ' . $key . ' prefix:' . $this->prefix, E_USER_NOTICE);
                }
            }
        }

        return isset($this->component[$key]) ? $this->component[$key] : null;
    }
}