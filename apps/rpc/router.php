<?php
class App_Router implements Router {

    private $services;

    /**
     * RpcRouter constructor.
     */
    public function __construct(){
        $this->services = $GLOBALS['services'];
    }

    /**
     * @param $input array
     * @return array
     */
    private function parseArgv($input) {
        $rid = isset($input['rid']) ? $input['rid'] : '';               //    request id
        $service = isset($input['service']) ? $input['service'] : '';   //    request service
        $method  = isset($input['method']) ? $input['method'] : '';
        $args    = isset($input['args']) ? $input['args'] : [];

        $router = [
            'flag' => false,
            'file' => '',
            'controller' => '',
            'action' => '',
            'params' => [],
            'msg' => ''
        ];

        if(empty($rid)) {
            $router['msg'] = 'rid is empty';
            return $router;
        }

        if(empty($service)) {
            $router['msg'] = 'service is empty';
            return $router;
        }

        if(empty($method)) {
            $router['msg'] = sprintf("'%s' service: '%s' method is empty", $service, $method);
            return $router;
        }

        // service config
        if(!array_key_exists($service, $this->services)) {
            $router['msg'] = sprintf("'%s' service not exists", $service);
            return $router;
        }

        $config = $this->services[$service];
        $interface = isset($config['interface']) ? $config['interface'] : '';
        if(empty($interface) || strpos($interface, "/") === false) {
            $router['msg'] = sprintf("%s service interface is error", $service);
            return $router;
        }

        // controlelr
        $parts = explode("/", $interface);
        $parts = array_map(function($v) {
            return ucfirst($v);
        }, $parts);

        // parse success
        $router['flag'] = true;
        $router['file'] = sprintf('%s_controller.php', $interface);                   // example:    test/index_controller.php
        $router['controller'] = sprintf('%s_Controller', implode('_', $parts));  // example:   Test_Index_Controller.php
        $router['action'] = $method;
        $router['params'] = $args;

        return $router;
    }

    /**
     * @return array
     * $input = ['rid' => 'rid', 'service' => 'test','method' => 'demo','args' => [1,2]];
     */
    public function route() {
        // parse rpc params
        $input_data = file_get_contents('php://input', 'r');
        $input = json_decode($input_data, true);

        $router = $this->parseArgv($input);
        return $router;
    }

    /**
     * @param $config
     */
    public function run($config) {
        $controller_path = isset($config['controller_path']) ? $config['controller_path'] : '';

        $response = [
            'ec' => 401,
            'em' => "",
            'data' => []
        ];
        if(!in_array(php_sapi_name(), ['cgi', 'cgi-fcgi', 'fpm-fcgi'])) {
            trigger_error('run mode must is cgi or cgi-fcgi or fpm-fcgi', E_USER_NOTICE);
            $response['em'] = 'run mode must is cgi or cgi-fcgi';
            exit(json_encode($response));
        }

        $router = $this->route();

        $flag = $router['flag'];
        $file = $router['file'];
        $controller = $router['controller'];
        $action = $router['action'];
        $params = $router['params'];

        if(!$flag) {
            trigger_error('route parse error:' . $router['msg'], E_USER_NOTICE);
            $response['em'] = 'route parse error:' . $router['msg'];
            exit(json_encode($response));
        }

        $file_path = $controller_path . $file;

        if(!is_file($file_path)) {
            trigger_error($file_path . ' file not found', E_USER_NOTICE);
            $response['em'] = $file_path . ' file not found';
            exit(json_encode($response));
        }

        require $file_path;

        if(!class_exists($controller, false)) {
            trigger_error($controller . ' controller not found', E_USER_NOTICE);
            $response['em'] = $controller . ' controller not found';
            exit(json_encode($response));
        }

        // reflect
        $reflect_class = null;
        try {
            $reflect_class = new ReflectionClass($controller);
        } catch (Exception $e){
            trigger_error($controller . ' controller reflect fail:' . $e->getMessage(), E_USER_NOTICE);
            $response['em'] = $controller . ' controller reflect fail:' . $e->getMessage();
            exit(json_encode($response));
        }

        if(!$reflect_class->hasMethod($action)) {
            trigger_error($controller . ' class not exists method:' . $action, E_USER_NOTICE);
            $response['em'] = $controller . ' class not exists method:' . $action;
            exit(json_encode($response));
        }
        $reflect_method = $reflect_class->getMethod($action);
        $parameters = $reflect_method->getParameters();
        if(count($params) > count($parameters)) {
            trigger_error($controller . ' class not exists method:' . $action . ' params count error', E_USER_NOTICE);
            $response['em'] = $controller . ' class not exists method:' . $action . ' params count error';
            exit(json_encode($response));
        }

        $controller_obj = new $controller();
        $reflect_method->invokeArgs($controller_obj, $params);
    }

}