<?php

require_once PUMPCMS_SYSTEM_PATH . '/pumpimage.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpcaptcha.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpfile.php';
require_once PUMPCMS_APP_PATH . '/config/default.php';
require_once PUMPCMS_APP_PATH . '/config/config.php';
require_once PUMPCMS_SYSTEM_PATH . '/db.php';
require_once PUMPCMS_SYSTEM_PATH . '/db_pdo.php';
require_once PUMPCMS_SYSTEM_PATH . '/benchmark.php';
require_once PUMPCMS_SYSTEM_PATH . '/config.php';
require_once PUMPCMS_SYSTEM_PATH . '/model.php';
require_once PUMPCMS_SYSTEM_PATH . '/main.php';
require_once PUMPCMS_SYSTEM_PATH . '/controller.php';
require_once PUMPCMS_SYSTEM_PATH . '/abort.php';
require_once PUMPCMS_SYSTEM_PATH . '/dbset.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpform.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpformconfig.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpormap.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpormap_util.php';
require_once PUMPCMS_SYSTEM_PATH . '/grant.php';
require_once PUMPCMS_SYSTEM_PATH . '/util.php';
require_once PUMPCMS_SYSTEM_PATH . '/siteinfo.php';
require_once PUMPCMS_SYSTEM_PATH . '/userinfo.php';
require_once PUMPCMS_SYSTEM_PATH . '/menu.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpimage.php';
require_once PUMPCMS_SYSTEM_PATH . '/notification.php';
require_once PUMPCMS_SYSTEM_PATH . '/wp_compatible.php';
require_once PUMPCMS_APP_PATH . '/module/user/class/actionlog.php';
require_once PUMPCMS_SYSTEM_PATH . '/debug.php';
require_once PUMPCMS_ROOT_PATH . '/external/password_compat/lib/password.php';
require_once PUMPCMS_SYSTEM_PATH . '/csrf_protection.php';
require_once PUMPCMS_SYSTEM_PATH . '/hook.php';
require_once PUMPCMS_APP_PATH . '/module/message/class/message_util.php';

$main = new PC_Main();
$main->run();
