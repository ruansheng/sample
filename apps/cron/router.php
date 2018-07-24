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
     * @param $config
     * @return array
     */
    public function run($config) {
        global $argv;
        $router = $this->parseArgv($argv);
        return $router;
    }

}