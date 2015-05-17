<?php

if (defined('PUMPCMS_ROOT_PATH') == false) {
    define('PUMPCMS_ROOT_PATH', dirname(pathinfo(__FILE__, PATHINFO_DIRNAME)));
    define('PUMPCMS_SYSTEM_PATH', PUMPCMS_ROOT_PATH . '/system');
    define('PUMPCMS_APP_PATH', PUMPCMS_ROOT_PATH . '/app');
    define('PUMPCMS_PUBLIC_PATH', PUMPCMS_ROOT_PATH . '/public');
}

require_once PUMPCMS_SYSTEM_PATH . '/benchmark.php';
require_once PUMPCMS_APP_PATH . '/config.php';
require_once PUMPCMS_SYSTEM_PATH . '/config.php';
require_once PUMPCMS_SYSTEM_PATH . '/model.php';
require_once PUMPCMS_SYSTEM_PATH . '/router.php';
require_once PUMPCMS_SYSTEM_PATH . '/controller.php';
require_once PUMPCMS_SYSTEM_PATH . '/abort.php';
require_once PUMPCMS_SYSTEM_PATH . '/db.php';
require_once PUMPCMS_SYSTEM_PATH . '/dbset.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpform.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpformconfig.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpormap.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpormap_util.php';
require_once PUMPCMS_SYSTEM_PATH . '/util.php';
require_once PUMPCMS_SYSTEM_PATH . '/siteinfo.php';
require_once PUMPCMS_SYSTEM_PATH . '/userinfo.php';
require_once PUMPCMS_SYSTEM_PATH . '/menu.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpimage.php';
require_once PUMPCMS_SYSTEM_PATH . '/wp_compatible.php';
require_once PUMPCMS_SYSTEM_PATH . '/debug.php';

class PC_Batch {
    function __construct() {
	$router = new PC_Router();
	$router->setup();
	$router->check_site();
	$router->check_lang();
    }
}

