<?php
session_start();

define('PUMPCMS_ROOT_PATH', dirname(pathinfo(__FILE__, PATHINFO_DIRNAME)));
define('PUMPCMS_SYSTEM_PATH', PUMPCMS_ROOT_PATH . '/system');
define('PUMPCMS_APP_PATH', PUMPCMS_ROOT_PATH . '/app');
define('PUMPCMS_PUBLIC_PATH', PUMPCMS_ROOT_PATH . '/public');

require_once PUMPCMS_SYSTEM_PATH . '/selfdiagnosis.php';
PumpSelfDiagnosis::diagnosis();

require_once PUMPCMS_ROOT_PATH . '/system/core.php';
