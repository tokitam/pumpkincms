<?php

$pc_config = array();

$pc_config['debug_mode'] = true;

$pc_config['site_list'] = array(
'example.com' => array('site_id' => 1),
'127.0.0.1/pumpcms/public' => array('site_id' => 2),
);
$pc_config['site_config_catchall'] = 1;

$pc_config['site_config'] = array(
1 => array('site_title' => 'foo1 test',
  'default_layout' => 'foo1',
  'db_no' => 1,

  // メール送信時に、from:ヘッダーへセットされるメールアドレス
  'from_email' => 'foo1 test<pumpcmsfrom1@pumpup.jp>',

  // ユーザアイコンをデフォルトから変更する
  'under_construction_image' => PUMPCMS_PUBLIC_PATH . '/themes/idoldd/uc.png',

  // 背景画像
  'bg_image_url' => 'http://dev11.idoldd.com/image/i/659_imo4rwqc.jpg',

  'blog' => array(
    1 => array('dir' => 'news', 'title' => 'ニュース'),
    2 => array('dir' => 'info', 'title' => 'インフォメーション'),
    3 => array('dir' => 'blog', 'title' => 'ブログ'),
    ),

  // 電話認証 twilio の設定
  'twilio_account_sid' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
  'twilio_auth_token' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
  'twilio_from_telno' => '+819999999999',

  // AWS の設定
  'aws_access_key' => 'XXXXXXXXXXXXXXXXXXXX',
  'aws_secret_key' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
  'aws_s3_bucket_name' => 'samplebucket',
  ),
2 => array('site_title' => 'testlayout', 
  'default_layout' => 'testlayout',
  'db_no' => 1,
  'from_email' => 'testlayout admin<pumpcmsfrom2@pumpup.jp>',
  ),
3 => array('site_title' => 'gouhouloli.jp',
  'default_layout' => 'testlayout',
  'db_no' => 2,
  'from_email' => 'gouhouloli.jp<pumpcmsfrom3@pumpup.jp>',
  ),
4 => array('site_title' => 'example',
  'default_layout' => 'shop',
  'db_no' => 1,
  'from_email' => 'gouhouloli.jp<pumpcmsfrom3@pumpup.jp>',
  ),
);

// 読み込むルーターの設定
$pc_config['router'][1][1] = 'shop';
$pc_config['router'][1][2] = 'blog';

// MySQL setting
$pc_config['database'][1]['db_type'] = 'pdo';
$pc_config['database'][1]['db_driver'] = 'mysql';
$pc_config['database'][1]['db_prefix'] = 'xzqb';
$pc_config['database'][1]['db_host'] = '127.0.0.1';
$pc_config['database'][1]['db_user'] = 'root';
$pc_config['database'][1]['db_pass'] = '';
$pc_config['database'][1]['db_name'] = 'sampledb';

// PostgreSQL setting
$pc_config['database'][2]['db_type'] = 'pdo';
$pc_config['database'][2]['db_driver'] = 'pgsql';
$pc_config['database'][2]['db_prefix'] = 'xzqb';
$pc_config['database'][2]['db_host'] = '127.0.0.1';
$pc_config['database'][2]['db_user'] = 'root';
$pc_config['database'][2]['db_pass'] = '';
$pc_config['database'][2]['db_name'] = 'sampledb';

// SQLite3 setting
$pc_config['database'][3]['db_type'] = 'pdo';
$pc_config['database'][3]['db_driver'] = 'sqlite';
$pc_config['database'][3]['db_prefix'] = 'xzqb';
$pc_config['database'][3]['db_name'] = 'sample.sqlite3';
