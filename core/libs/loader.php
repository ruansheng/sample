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
