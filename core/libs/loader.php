<?php
/**
 * Created by PhpStorm.
 * User: ruansheng
 * Date: 15/6/9
 * Time: 22:05
 */

/**
 * load file
 * @param $file_path
 */
function loader($file_path = '') {
    if ($file_path == '') {
        echo '[' . __FUNCTION__ . '] file path is empty';
        exit;
    }
    $dirs = explode('::', $file_path);
    $file = CORE_BASE_DIR . '/' . implode('/', $dirs);
    if (!file_exists($file)) {
        echo '[' . __FUNCTION__ . '] ' . $file . ' is not exists';
        exit;
    }

    include($file);
}

/**
 * load dir file
 * @param $dir_array
 */
function loader_dir($dir_array = array()) {
    if(!empty($dir_array) && is_array($dir_array)) {
        $paths = implode(PATH_SEPARATOR, $dir_array);
        set_include_path($paths);
        foreach($dir_array as $dir) {
            $dir = opendir($dir);
            while (($file = readdir($dir)) !== false) {
                if($file != '.' && $file != '..') {
                    include($file);
                }
            }
            closedir($dir);
        }
    }
}