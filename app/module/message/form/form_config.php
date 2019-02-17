<?php

$pumpform_config['message']['message'] = array(
    'module' => 'message',
    'title' => 'message',
    'table' => 'message',

    'list_limit' => 10,
    'default_sort' => 'd_id',
                     
    'column' => array(

    'from_uesr_id' => array('name' => 'from_uesr_id',
          'title' => 'from_user_id',
          'type' => PUMPFORM_INT,
          'required' => 0,
          'visible' => 1,
          'registable' => 1,
          'editable' => 1,
          'list_visible' => 1),
    'to_uesr_id' => array('name' => 'to_uesr_id',
          'title' => 'to_user_id',
          'type' => PUMPFORM_INT,
          'required' => 0,
          'visible' => 1,
          'registable' => 1,
          'editable' => 1,
          'list_visible' => 1),
    'text' => array('name' => 'text',
          'title' => 'text',
          'type' => PUMPFORM_TEXT,
          'required' => 1,
          'visible' => 1,
          'registable' => 1,
          'editable' => 1,
          'list_visible' => 1,
          'minlenth' => 0,
          'maxlength' => 2000),
    'browsed' => array('name' => 'browsed',
          'title' => 'browsed',
          'type' => PUMPFORM_INT,
          'required' => 0,
          'visible' => 1,
          'registable' => 1,
          'editable' => 1,
          'list_visible' => 1),

    ),
);
