<?php

require_once PUMPCMS_SYSTEM_PATH . '/pumpimage.php';

$pc_config['debug_mode'] = true;
$pc_config['allow_register'] = true;

$pc_config['default_module'] = 'index';
$pc_config['default_controller'] = 'index';

// パスワードリセットメールの有効期間 60*5 = 5分
$pc_config['remindpass_time'] = (60 * 5);

// アップロード画像の格納場所
// PumpUpload::STORE_TYPE_LOCAL : ローカルディスクに格納
// PumpUpload::STORE_TYPE_DB : データベースへ格納
// PumpUpload::STORE_TYPE_S3 : AWS S3 へ格納
$pc_config['pumpimage_store_type'] = PumpUpload::STORE_TYPE_LOCAL;

// アップロードファイルの格納場所
// PumpUpload::STORE_TYPE_LOCAL : ローカルディスクに格納
// PumpUpload::STORE_TYPE_DB : データベースへ格納
// PumpUpload::STORE_TYPE_S3 : AWS S3 へ格納
$pc_config['pumpfile_store_type'] = PumpUpload::STORE_TYPE_LOCAL;

// アクションログを記録するかの設定
// true: 記録する
// true以外： 記録しない
$pc_config['enable_action_log'] = true;

// log directory
$pc_config['log_dir'] = PUMPCMS_APP_PATH . '/log';

$pc_config['session.cookie_lifetime'] = (60 * 60 * 24 * 365);
$pc_config['session.gc_maxlifetime'] = (60 * 60 * 24 * 365);

//$pc_config['password_hash'] = 'MD5';

