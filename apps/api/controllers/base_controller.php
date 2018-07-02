<?php

/**
 * Class Base_Controller
 */
class Base_Controller {

    protected $ctx;
    protected $base_ctx;

    protected $output = [];

    public function __construct() {
        $this->ctx = Ctx::getInstance();
        $this->base_ctx = Base_Ctx::getInstance();
    }

    /**
     * @param int $ec
     * @param string $em
     */
    public function responseJson($ec = 200, $em = 'success') {
        $data = [
            'ec' => $ec,
            'em' => $em,
            'data' => $this->output
        ];
        exit(json_encode($data));
    }
}