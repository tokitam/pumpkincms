<?php

$pumpform_config['simplebbs']['simplebbs'] = array(
    'module' => 'simplebbs',
    'title' => 'Simple BBS',
    'table' => 'simplebbs',

//    'list_php' => 'list',

    'list_limit' => 4,
    'default_sort' => 'd_id',

    'column' => array(
        array('name' => 'id',
       		'title' => 'ID',
	      'type' => PUMPFORM_PRIMARY_ID,
	      'visible' => 1,
	      'list_visible' => 0),
        array('name' => 'site_id',
              'type' => PUMPFORM_SITE_ID,
              'visible' => 0),
        array('name' => 'reg_time',
              'title' => _MD_PUMPFORM_REG_TIME,
              'type' => PUMPFORM_TIME,
              'visible' => 1,
              'list_visible' => 0),
        array('name' => 'mod_time',
              'type' => PUMPFORM_TIME,
              'visible' => 0),
        array('name' => 'reg_user',
              'type' => PUMPFORM_USER,
              'visible' => 0),
        array('name' => 'mod_user',
              'type' => PUMPFORM_USER,
              'visible' => 0),
		      
	array('name' => 'body',
	      'title' => 'body',
	      'type' => PUMPFORM_MARKDOWN,
	      'cols' => 50,
	      'rows' => 5,
	      'required' => 0,
	      'visible' => 1,
	      'registable' => 1,
	      'editable' => 1,
	      'list_visible' => 1,
	      'minlenth' => 3,
	      'maxlength' => 20000),
	array('name' => 'image_id',
	      'title' => 'image',
	      'type' => PUMPFORM_IMAGE,
	      'required' => 0,
	      'visible' => 1,
	      'registable' => 1,
	      'editable' => 1,
	      'list_visible' => 1,
	      'crop' => 1),
	array('name' => 'movie_url',
	      'title' => 'youtube',
	      'type' => PUMPFORM_YOUTUBE,
	      'required' => 0,
	      'visible' => 1,
	      'registable' => 1,
	      'editable' => 1,
	      'list_visible' => 0),

    ),		      
);
					 
