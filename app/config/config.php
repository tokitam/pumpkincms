<?php

$pc_config['debug_mode'] = true;

$pc_config['site_list'] = array(
'example.com' => array('site_id' => 1),
  'localhost/pumpkincms/public' => array('site_id' => 1),
);
$pc_config['site_config_catchall'] = 1;

$pc_config['site_config'] = array(
1 => array('site_title' => 'PumpkinCMS',
  'default_layout' => 'default',
  'db_no' => 1,

  // from header mail address at sending
  'from_email' => 'admin<example@example.com>',
    'css_url' => 'http://localhost/pumpkincms/public',
  // custom default user icon url
  //'under_construction_image' => PUMPCMS_PUBLIC_PATH . '/themes/uc.png',

  // custom background url
  //'bg_image_url' => 'http://example.com/sample.jpg',

  'blog' => array(
    1 => array('dir' => 'news', 'title' => 'NEWS'),
    2 => array('dir' => 'info', 'title' => 'INFORMATION'),
    3 => array('dir' => 'blog', 'title' => 'BLOG'),
    ),

  // telauth twilio setting
  'twilio_account_sid' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
  'twilio_auth_token' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
  'twilio_from_telno' => '+819999999999',

  // AWS setting
  'aws_access_key' => 'XXXXXXXXXXXXXXXXXXXX',
  'aws_secret_key' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
  'aws_s3_bucket_name' => 'samplebucket',
  ),
2 => array('site_title' => 'testlayout', 
  'default_layout' => 'default',
  'db_no' => 1,
  'from_email' => 'testlayout admin<pumpcmsfrom2@pumpup.jp>',
  ),
3 => array('site_title' => 'example',
  'default_layout' => 'shop',
  'db_no' => 1,
  'from_email' => 'gouhouloli.jp<pumpcmsfrom3@pumpup.jp>',
  ),
);

// routing setting
//$pc_config['router'][1][1] = 'shop';
//$pc_config['router'][1][2] = 'blog';

// MySQL setting
$pc_config['database'][1]['db_type'] = 'pdo';
$pc_config['database'][1]['db_driver'] = 'mysql';
$pc_config['database'][1]['db_prefix'] = 'xzqb';
$pc_config['database'][1]['db_host'] = '127.0.0.1';
$pc_config['database'][1]['db_user'] = 'root';
$pc_config['database'][1]['db_pass'] = '190500';
$pc_config['database'][1]['db_name'] = 'pumpkincms';

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
