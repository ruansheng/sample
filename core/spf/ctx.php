<?php

/**
 * Class Core_Ctx
 */
class Core_Ctx {

    protected $component = [];
    protected $prefix = '';

    /**
     * Core_Ctx constructor.
     * @param null $ctx
     */
    public function __construct($ctx = null){
        $class = get_class($this);
        if(!$this->prefix) {
            $pos = strrpos($class, '_');
            if($pos !== false) {
                $this->prefix = substr($class, 0, $pos + 1);
            }
        }
    }

    /**
     * @param $key
     * @return mixed|null
     */
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