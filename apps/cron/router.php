<?php
class App_Router implements Router {

    /**
     * @param $argv
     * @return array
     */
    private function parseArgv($argv) {
        if(count($argv) == 1) {
            $this->echoHelp();
            exit;
        }

        $file = "";
        $controller = "";
        $action = "";
        $params = [];
        foreach($argv as $index => $spe) {
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
            } elseif (strpos($spe, "-p=") === 0) {
                parse_str(substr($spe, 3), $params);
            }
        }

        $router = [
            'file' => $file,
            'controller' => $controller,
            'action' => $action,
            'params' => $params
        ];
        return $router;
    }

    /**
     * echo Help
     */
    private function echoHelp() {
        echo 'Usage: php index_cron.php [options]' . PHP_EOL;
        echo '      -h                       show help' . PHP_EOL;
        echo '      -c=<controller name>    route call controller name. example: -c="test/index"' . PHP_EOL;
        echo '      -m=<method name>        route call method name. example: -m="index"' . PHP_EOL;
        echo '      -p=<params>             call method params. example: -p="a=1&b=2"' . PHP_EOL;
    }

    /**
     * @return array
     */
    public function route() {
        global $argv;
        $router = $this->parseArgv($argv);
        return $router;
    }

    /**
     * @param $config
     */
    public function run($config) {
        $controller_path = isset($config['controller_path']) ? $config['controller_path'] : '';

        if(php_sapi_name() != 'cli') {
            trigger_error('run mode must is cli', E_USER_NOTICE);
            exit(-1);
        }

        $router = $this->route();
        $file = $router['file'];
        $controller = $router['controller'];
        $action = $router['action'];
        $params = $router['params'];

        $file_path = $controller_path . $file;

        if(!is_file($file_path)) {
            trigger_error($file_path . ' file not found', E_USER_NOTICE);
            exit(-1);
        }

        require $file_path;

        if(!class_exists($controller, false)) {
            trigger_error($controller . ' controller not found', E_USER_NOTICE);
            exit(-1);
        }

        $controller_obj = new $controller();

        if(!method_exists($controller_obj, $action)) {
            trigger_error($controller . ' controller not exists method ' . $action, E_USER_NOTICE);
            exit(-1);
        }

        $controller_obj->params = $params;
        $controller_obj->file = $file;
        $controller_obj->method = $action;
        $controller_obj->start_time = microtime(true);
        call_user_func_array([$controller_obj, $action], []);
        $controller_obj->end_time = microtime(true);
        call_user_func([$controller_obj, "info"]);
    }

}