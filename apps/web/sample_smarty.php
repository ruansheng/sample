<?php

class Sample_Smarty  extends Smarty{

    public function __construct() {
        parent::__construct();
        $this->initSmarty();
    }

    private function initSmarty() {
        $this->template_dir = APPS_DIR . '/web/views';
        $this->compile_dir  = "/tmp/smarty/views/smarty_complie_dir";
        $this->cache_dir = "/tmp/smarty/views/smarty_cache_dir";
        $this->debugging = false;
        $this->caching  = false;
        $this->cache_lifetime = 60;
        $this->left_delimiter  = '{{';
        $this->right_delimiter = '}}';
        $this->error_reporting = E_ALL & ~E_NOTICE;

        if (!is_dir($this->compile_dir)) {
            mkdir($this->compile_dir, 755, true);
        }

        if (!is_dir($this->cache_dir)) {
            mkdir($this->cache_dir, 755, true);
        }
    }
}