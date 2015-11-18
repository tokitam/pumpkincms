<?php

$pumpform_config['note']['note'] = array(
    'module' => 'note',
    'title' => 'Simple note',
    'table' => 'note',

//    'list_php' => 'list',

    'list_limit' => 4,
    'default_sort' => 'd_id',
    'has_active_tag' = true,

    'column' => array(

	array('name' => 'title',
		'title' => 'title',
		'type' => PUMPFORM_TEXT,
		'required' => 0,
		'visible' => 1,
		'registable' => 1,
		'editable' => 1,
		'list_visible' => 1,
		'minlength' => 1,
		'maxlength' => 256),
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
	),   
);
					 
