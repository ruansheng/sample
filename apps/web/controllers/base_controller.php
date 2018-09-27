<?php

/**
 * Class Base_Controller
 */
class Base_Controller {

    protected $ctx;
    public $request;
    protected $output = [];
    private $smarty;

    public function __construct() {
        $this->ctx = Ctx::getInstance();
        $this->request = new Request();
        $this->smarty = new Sample_Smarty();
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

    /**
     * @param $template
     */
    public function display($template) {
        header('Content-Type: text/html; charset=utf-8');
        foreach ($this->output as $key => $val) {
            $this->smarty->assign($key, $val);
        }
        $this->smarty->display($template);
    }

}
