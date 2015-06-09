<?php
/**
 * Created by PhpStorm.
 * User: ruansheng
 * Date: 15/6/9
 * Time: 21:57
 */

/**
 * print output
 * @param $var
 */
function _dump($var) {
    echo '<pre>';
    print_r($var);
    echo '</pre>';
}

/**
 * autoload
 * @param $calss_name
 */
function __autoload($calss_name) {
    include(CORE_BASE_DIR."/libs/" . $calss_name . ".php");
}

/**
 * is or not ajax request
 * @return bool
 */
function isAjax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'XMLHttpRequest';
}