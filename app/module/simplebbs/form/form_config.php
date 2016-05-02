<?php

$pumpform_config['simplebbs']['simplebbs'] = array(
    'module' => 'simplebbs',
    'title' => 'Simple BBS',
    'table' => 'simplebbs',

//    'list_php' => 'list',

    'list_limit' => 4,
    'default_sort' => 'd_id',

    'column' => array(

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
	'file_id' => array('name' => 'file_id',
	      'title' => 'file',
	      'type' => PUMPFORM_FILE,
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
					 
