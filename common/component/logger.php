<?php

/**
 * @param $errno
 * @param $errstr
 * @param $errfile
 * @param $errline
 * @return bool
 */
function errorHandler($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return false;
    }

    $request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    switch ($errno) {
        case E_USER_ERROR:
        case E_ERROR:
            $error_type = 'Error';
            break;
        case E_USER_WARNING:
        case E_WARNING:
            $error_type = 'Warning';
            break;
        case E_USER_NOTICE:
        case E_NOTICE:
            $error_type = 'Notice';
            break;
        default:
            $error_type = 'Unknown';
            break;
    }

    $timezone = date_default_timezone_get();
    $request_uri_content = $request_uri ? sprintf('   [REQUEST_URI:%s]', $request_uri) : '   [REQUEST_URI: Unkown]';
    $text = sprintf("[%s %s] %s  %s in %s  on line %s %s \n", date('d-M-Y H:i:s'), $timezone, $error_type, $errstr, $errfile, $errline, $request_uri_content);

    $log_file = isset($GLOBALS['log_file']) ? $GLOBALS['log_file'] : '/var/log/php.fpm.log';
    if(is_writeable($log_file)) {
        file_put_contents($log_file, $text, FILE_APPEND);
    }

    return true;
}