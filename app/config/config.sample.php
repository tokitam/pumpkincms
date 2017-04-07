<?php

$pc_config['site_list'] = array(
'127.0.0.1/pumpkincms/public' => array('site_id' => 1),
'example.com' => array('site_id' => 2),
'example.net' => array('site_id' => 3),
);
$pc_config['site_config_catchall'] = 1;

$pc_config['site_config'] = array(
1 => array('site_title' => 'PumpkinCMS',
  'theme' => 'default',
  'db_no' => 1,

  // router setting
  //'router_no' => 1,

  // css_url setting
  //'css_url' => 'http://127.0.0.1/pumpkincms/public',

  'mail_function' => 'mail', // use php mail() function
  //'mail_function' => 'phpmailer', // use PHPMailer library
	   
  // admin mail
  'admin_email' => '[your email]',

  // from header mail address at sending
  'from_email' => 'admin<example@example.com>',

  'phpmailer_host' => 'ssl://smtp.gmail.com',
  'phpmailer_user' => 'user@example.com',
  'phpmailer_pass' => '[your password]',
  'phpmailer_secure' => 'tls',
  'phpmailer_port' => 587,

  // custom default user icon url
  //'under_construction_image' => PUMPCMS_PUBLIC_PATH . '/themes/uc.png',

  // custom background url
  //'bg_image_url' => 'http://example.com/sample.jpg',

  'blog' => array(
    1 => array('dir' => 'blog', 'title' => 'BLOG'),
    2 => array('dir' => 'news', 'title' => 'NEWS'),
    3 => array('dir' => 'info', 'title' => 'INFORMATION'),
    ),

  // twitter setting
  'twitter_auth' => 0,
  'twitter_consumer_key' => 'XXXXXXXXXXXXXXXXXXXXXXXXX',
  'twitter_consumer_secret' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',

  // facebook setting
  'facebook_auth' => 0,
  'facebook_app_id' => 'XXXXXXXXXXXXXXX',
  'facebook_app_secret' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',

  // telauth twilio setting
  'use_tel_auth' => 0,
  'twilio_account_sid' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
  'twilio_auth_token' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
  'twilio_from_telno' => '+819999999999',

  // AWS setting
  'aws_access_key' => 'XXXXXXXXXXXXXXXXXXXX',
  'aws_secret_key' => 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX',
  'aws_s3_bucket_name' => 'samplebucket',
  ),
2 => array('site_title' => 'testlayout', 
  'default_theme' => 'testlayout',
  'db_no' => 1,
  'from_email' => 'testlayout admin<pumpcmsfrom2@pumpup.jp>',
  ),
3 => array('site_title' => 'example',
  'default_theme' => 'shop',
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
