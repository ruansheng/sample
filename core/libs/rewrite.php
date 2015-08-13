<?php
/**
 * parse rewrite
 * @param $uri
 * @return string
 */
function rewrite($uri) {
    $parse_uri = parse_url($uri);
    $dir_array = explode('/', $parse_uri['path']);
    $paths = array();
    foreach($dir_array as $v) {
        if(!empty($v)){
            $paths[] = $v;
        }
    }
    $class_name = array_pop($paths);
    $func_action = Request::get('action');
    if(empty($class_name)) {
        $class_name = 'index_controller';
    }
    if(empty($func_action)) {
        $func_action = 'index';
    }
    $file_name = $class_name . '.php';
    $file_path = APP_BASE_DIR.'/controller'.implode('/',$paths);
    $file = $file_path.'/'.$file_name;
    include($file);

    $controller = new $class_name();
    $controller->$func_action();
}