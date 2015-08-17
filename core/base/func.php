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

/**
 * template
 * @param $text
 */
function errorTemplate($text) {
    echo '<div style="width:800px;height:50px;line-height:50px;margin:0 auto;margin-top:200px;border:1px solid gray;color:red;text-align:center;">'.$text.'</div>';
}