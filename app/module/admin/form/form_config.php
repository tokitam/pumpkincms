<?php

$pumpform_config['admin']['config'] = array(
	'module' => 'admin',
	'title' => 'config',
	'table' => 'config',
	'column' => array(

		'name' => array('name' => 'name',
			'title' => 'name',
			'type' => PUMPFORM_TEXT,
			'visible' => 1,
			'registable' => 1,
			'editable' => 1,
			'list_visible' => 1,),
		'value' => array('name' => 'value',
			'title' => 'value',
			'type' => PUMPFORM_TEXT,
			'visible' => 1,
			'registable' => 1,
			'editable' => 1,
			'list_visible' => 1,),
    ),
);


$pumpform_config['admin']['config_form'] = array(
	'module' => 'admin',
	'title' => _MD_ADMIN_SETTING,
	'table' => 'config_form',
	'column' => array(

		'title' => array('name' => 'site_title',
			'title' => _MD_ADMIN_SITE_TITLE,
			'type' => PUMPFORM_TEXT,
			'visible' => 1,
			'registable' => 1,
			'editable' => 1,
			'list_visible' => 1,),
		'description' => array('name' => 'description',
			'title' => _MD_ADMIN_DESCRIPTION,
			'type' => PUMPFORM_TEXTAREA,
			'visible' => 1,
			'registable' => 1,
			'editable' => 1,
			'list_visible' => 1,),
		'keywords' => array('name' => 'keywords',
			'title' => _MD_ADMIN_KEYWORDS,
			'type' => PUMPFORM_TEXT,
			'visible' => 1,
			'registable' => 1,
			'editable' => 1,
			'list_visible' => 1,),
		'debug_mode' => array('name' => 'debug_mode',
			'title' => _MD_ADMIN_DEBUG_MODE,
			'type' => PUMPFORM_SELECT,
			//'placeholder' => _MD_SHOP_STATUS,
			'required' => 0,
			'visible' => 1,
			'registable' => 1,
			'editable' => 1,
			'list_visible' => 0,
			'option' => array(
				0 => 'OFF',
				1 => 'ON',
				)
			),
		'site_close' => array('name' => 'site_close',
			'title' => _MD_ADMIN_SITE_CLOSE,
			'type' => PUMPFORM_SELECT,
			//'placeholder' => _MD_SHOP_STATUS,
			'required' => 0,
			'visible' => 1,
			'registable' => 1,
			'editable' => 1,
			'list_visible' => 0,
			'option' => array(
				0 => _MD_ADMIN_SITE_CLOSE_ON,
				1 => _MD_ADMIN_SITE_CLOSE_OFF,
				)
			),
		'site_close_message' => array('name' => 'site_close_message',
			'title' => _MD_ADMIN_SITE_CLOSE_MESSAGE,
			'type' => PUMPFORM_TEXTAREA,
			//'placeholder' => _MD_SHOP_STATUS,
			'required' => 0,
			'visible' => 1,
			'registable' => 1,
			'editable' => 1,
			'list_visible' => 0,
			'option' => array(
				0 => _MD_ADMIN_SITE_CLOSE_ON,
				1 => _MD_ADMIN_SITE_CLOSE_OFF,
				)
			),
                'allow_register' => array('name' => 'allow_register',
                        'title' => _MD_ADMIN_ALLOW_REGISTER,
                        'type' => PUMPFORM_SELECT,
                        'required' => 0,
                        'visible' => 1,
                        'registable' => 1,
                        'editable' => 1,
                        'list_visible' => 0,
                        'option' => array(
                                1 => _MD_ADMIN_ALLOW_REGISTER_OK,
                                0 => _MD_ADMIN_ALLOW_REGISTER_NG,
                                )
                        ),
		'bg_image_url' => array('name' => 'bg_image_url',
			'title' => 'bg_image_url',
			'type' => PUMPFORM_TEXT,
			'visible' => 1,
			'registable' => 1,
			'editable' => 1,
			'list_visible' => 1,),
			  /*
		'cookie_lifetime' => array('name' => 'cookie_lifetime',
			'title' => 'cookie_lifetime',
			'type' => PUMPFORM_TEXT,
			'visible' => 1,
			'registable' => 1,
			'editable' => 1,
			'list_visible' => 1,
			'default' => (60 * 60 * 24 * 365)),
		'gc_maxlifetime' => array('name' => 'gc_maxlifetime',
			'title' => 'gc_maxlifetime',
			'type' => PUMPFORM_TEXT,
			'visible' => 1,
			'registable' => 1,
			'editable' => 1,
			'list_visible' => 1,
			'default' => (60 * 60 * 24 * 365),),
			   */
    ),
);



