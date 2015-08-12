<?php
/**
 * sample.php
 * @author ruansheng
 * @since  2015-06-09
 */

defined('HOST') || define('HOST',$_SERVER['HTTP_HOST']);
defined('PORT') || define('PORT',$_SERVER['SERVER_PORT']);
defined('URI') || define('URI',$_SERVER['REQUEST_URI']);
defined('METHOD') || define('METHOD',$_SERVER['REQUEST_METHOD']);

defined('CORE_BASE_DIR') || define('CORE_BASE_DIR',dirname(__FILE__));

//load frame libs
require_once(CORE_BASE_DIR.'/libs/func.php');
require_once(CORE_BASE_DIR.'/libs/rewrite.php');
require_once(CORE_BASE_DIR.'/libs/loader.php');

/**
 * run frame
 */
function run() {
    Loader('libs::request.php');

    //run rewrite
    rewrite(URI);
}