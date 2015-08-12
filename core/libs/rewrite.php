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
        $class_name = 'index';
    }
    if(empty($func_action)) {
        $func_action = 'index';
    }
    $file_name = $class_name . '_controller.php';
    $file_path = APP_BASE_DIR.implode('/',$paths);
    $file = $file_path.'/'.$file_name;
    return $file;
}