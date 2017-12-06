<?php

$pumpform_config['user']['user'] = array(
    'module' => 'user',
    'title' => _MD_USER,
    'table' => 'user',

    'default_sort' => 'd_id',

    'column' => array(

        'name' => array('name' => 'name',
                         'type' => PUMPFORM_TEXT,
                         'title' => _MD_USER_NAME,
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'display_name' => array('name' => 'display_name',
                         'type' => PUMPFORM_TEXT,
                         'title' => _MD_USER_DISPLAY_NAME,
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'email' => array('name' => 'email',
                         'type' => PUMPFORM_EMAIL,
                         'title' => _MD_USER_EMAIL,
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'password' => array('name' => 'password',
                         'type' => PUMPFORM_PASSWORD,
                         'title' => _MD_USER_PASSWORD,
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'profile' => array('name' => 'profile',
                         'type' => PUMPFORM_MARKDOWN,
                         'title' => _MD_USER_PROFILE,
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 0,),
        'last_login_time' => array('name' => 'last_login_time',
                         'title' => 'last_log_time',
                         'type' => PUMPFORM_TIME,
                         'display' => 0,
                         'visible' => 1, ),

    'image_id' => array('name' => 'image_id',
          'title' => _MD_USER_ICON,
          'type' => PUMPFORM_IMAGE,
          'required' => 0,
          'visible' => 1,
          'registable' => 1,
          'editable' => 1,
          'list_visible' => 1,
          'minlenth' => 3,
          'maxlength' => 10000),
    'flg_premium' => array('name' => 'flg_premium',
          'title' => 'flg_premium',
          'type' => PUMPFORM_RADIO,
          'required' => 0,
          'visible' => 1,
          'registable' => 1,
          'editable' => 1,
          'list_visible' => 0,
		  'option' => [0 => 'OFF', 1 => 'ON']),
    'payment_type' => array('name' => 'payment_type',
          'title' => 'payment_type',
          'type' => PUMPFORM_INT,
          'required' => 0,
          'visible' => 1,
          'registable' => 1,
          'editable' => 1,
          'list_visible' => 0,
		  'default' => 0),
    'auth' => array('name' => 'auth',
          'title' => _MD_USER_AUTH,
          'type' => PUMPFORM_RADIO,
          'required' => 0,
          'visible' => 1,
          'registable' => 1,
          'editable' => 1,
          'list_visible' => 1,
	  'option' => array(0 => _MD_USER_AUTH_GENERAL_USER, 1 => _MD_USER_AUTH_ADMIN_USER)),
    
      'tel_country' => array('name' => 'tel_country',
            'title' => 'tel_country',
            'type' => PUMPFORM_TEXT,
            'required' => 0,
          'visible' => 0,
          'registable' => 0,
          'editable' => 0),
      'tel_no' => array('name' => 'tel_no',
            'title' => 'tel_no',
            'type' => PUMPFORM_TEXT,
            'required' => 0,
          'visible' => 0,
          'registable' => 0,
          'editable' => 0),
      'vote_disable_time' => array('name' => 'vote_disable_time',
            'title' => 'vote_disable_time',
            'type' => PUMPFORM_INT,
            'required' => 0,
          'visible' => 0,
          'registable' => 0,
          'editable' => 0),

      array('name' => 'count_good',
            'title' => _MD_USER_COUNT_GOOD,
            'type' => PUMPFORM_INT,
            'required' => 0,
          'visible' => 0,
          'registable' => 0,
          'editable' => 0),
        array('name' => 'count_bad',
            'title' => _MD_USER_COUNT_BAD,
            'type' => PUMPFORM_INT,
            'required' => 0,
          'visible' => 0,
          'registable' => 0,
          'editable' => 0),

        ),
);

$pumpform_config['user']['actionlog'] = array(
    'module' => 'user',
    'title' => _MD_USER,
    'table' => 'actionlog',
           
    'default_sort' => 'd_id',
           
    'column' => array(

        'user_id' => array('name' => 'user_id',
                         'type' => PUMPFORM_INT,
                         'title' => 'user_id',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'type' => array('name' => 'type',
                         'type' => PUMPFORM_INT,
                         'title' => 'type',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'ip_address' => array('name' => 'ip_address',
                         'type' => PUMPFORM_INT,
                         'title' => 'ip_address',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'desc' => array('name' => 'desc',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'desc',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'user_agent' => array('name' => 'user_agent',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'desc',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'param1' => array('name' => 'param1',
                         'type' => PUMPFORM_INT,
                         'title' => 'param1',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'param2' => array('name' => 'param2',
                         'type' => PUMPFORM_INT,
                         'title' => 'param2',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'param3' => array('name' => 'param3',
                         'type' => PUMPFORM_INT,
                         'title' => 'param3',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'param4' => array('name' => 'param4',
                         'type' => PUMPFORM_INT,
                         'title' => 'param4',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),


        ),
);

$pumpform_config['user']['tel_auth'] = array(
    'module' => 'user',
    'title' => 'user_tel_auth',
    'table' => 'tel_auth',
           
    'default_sort' => 'd_id',
           
    'column' => array(

        'user_id' => array('name' => 'user_id',
                         'type' => PUMPFORM_INT,
                         'title' => 'user_id',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'code' => array('name' => 'code',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'code',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'flg_fnish' => array('name' => 'flg_fnish',
                         'type' => PUMPFORM_INT,
                         'title' => 'flg_fnish',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'check_string' => array('name' => 'check_string',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'check_string',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),

        'tel_country' => array('name' => 'tel_country',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'tel_country',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),

        'tel_no' => array('name' => 'tel_no',
                         'type' => PUMPFORM_TEXT,
                         'title' => 'tel_no',
                         'required' => 0,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),


        ),
);

$pumpform_config['user']['user_rel'] = array(
    'module' => 'user',
    'title' => 'user_rel',
    'table' => 'user_rel',
           
    'default_sort' => 'd_id',
           
    'column' => array(

        'user_id1' => array('name' => 'user_id1',
                         'type' => PUMPFORM_INT,
                         'title' => 'user_id1',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),
        'user_id2' => array('name' => 'user_id2',
                         'type' => PUMPFORM_INT,
                         'title' => 'user_id2',
                         'required' => 1,
                         'visible' => 1,
                         'registable' => 1,
                         'editable' => 1,
                         'list_visible' => 1,),

        ),
);
