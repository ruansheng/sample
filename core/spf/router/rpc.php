<?php

/**
 * Class RpcRouter
 */
class RpcRouter {

    public function __construct(){}

    private function parseArgv($params) {
        // parse rpc params
        $input_data = file_get_contents('php://input', 'r');
        $input = json_decode($input_data, true);

        $service = $input['service'];//    /service/php/test_index
        $args    = $input['args'];
        $method  = $input['method'];


        if(count($params) == 1) {
            $this->echoHelp();
            exit;
        }

        $file = "";
        $controller = "";
        $action = "";
        foreach($params as $index => $spe) {
            if($index == 0) {
                continue;
            }
            if(strpos($spe, "-c=") === 0) {
                $value = substr($spe, 3);
                if(strpos($spe, "/") === false) {
                    continue;
                }

                // file
                $file = '/' . $value . '_controller.php';

                // controlelr
                $parts = explode("/", $value);
                $parts = array_map(function ($v){
                    return ucfirst($v);
                }, $parts);
                $controller = implode('_', $parts) . '_Controller';
            } elseif (strpos($spe, "-m=") === 0) {
                $action = substr($spe, 3);
            }
        }

        $router = [
            'file' => $file,
            'controller' => $controller,
            'action' => $action
        ];
        return $router;
    }

    private function echoHelp() {
        echo 'Usage: php index_cron.php [options]' . PHP_EOL;
        echo '      -h                       show help' . PHP_EOL;
        echo '      -c=<controller name>    route call controller name. example: -c="test/index"' . PHP_EOL;
        echo '      -m=<method name>        route call method name. example: -m="index"' . PHP_EOL;
        echo '      -p=<params>             call method params. example: -p="a=1&b=2"' . PHP_EOL;
    }

    public function route() {
        global $argv;
        $router = $this->parseArgv($argv);
        return $router;
    }
}