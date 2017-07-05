<?php

$pumpform_config['fileuptest']['fileuptest'] = array(
    'module' => 'fileuptest',
    'title' => 'fileuptest',
    'table' => 'fileuptest',

    'list_limit' => 4,
    'default_sort' => 'd_id',

    'column' => array(

    array('name' => 'body',
          'title' => 'body',
          'type' => PUMPFORM_TINYMCE,
          'cols' => 50,
          'rows' => 5,
          'required' => 0,
          'visible' => 1,
          'registable' => 1,
          'editable' => 1,
          'list_visible' => 1,
          'minlenth' => 3,
          'maxlength' => 20000),
    array('name' => 'file_id',
          'title' => 'file',
          'type' => PUMPFORM_FILE,
          'required' => 0,
          'visible' => 1,
          'registable' => 1,
          'editable' => 1,
          'list_visible' => 0,
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
