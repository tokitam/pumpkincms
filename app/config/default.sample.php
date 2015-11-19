<?php

require_once PUMPCMS_SYSTEM_PATH . '/pumpimage.php';

$pc_config['debug_mode'] = true;
$pc_config['allow_register'] = true;

$pc_config['default_module'] = 'index';
$pc_config['default_controller'] = 'index';

// Password reset mail expire time 60*5 = 5minitus
$pc_config['remindpass_time'] = (60 * 5);

// Location of upload image
// PumpUpload::STORE_TYPE_LOCAL : Local disk
// PumpUpload::STORE_TYPE_DB : Database
// PumpUpload::STORE_TYPE_S3 : AWS S3
$pc_config['pumpimage_store_type'] = PumpUpload::STORE_TYPE_LOCAL;

// Location of upload file
// PumpUpload::STORE_TYPE_LOCAL : Local disk
// PumpUpload::STORE_TYPE_DB : Database
// PumpUpload::STORE_TYPE_S3 : AWS S3
$pc_config['pumpfile_store_type'] = PumpUpload::STORE_TYPE_LOCAL;

// Action log setting
// true: Record
// true以外： No record
$pc_config['enable_action_log'] = true;

// log directory
$pc_config['log_dir'] = PUMPCMS_APP_PATH . '/log';

$pc_config['cookie_lifetime'] = (60 * 60 * 24 * 365);
$pc_config['gc_maxlifetime'] = (60 * 60 * 24 * 365);

//$pc_config['password_hash'] = 'MD5';
//$pc_config['password_hash'] = 'SHA1';

