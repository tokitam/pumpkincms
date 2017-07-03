<?php

$pumpform_config['contact']['contact'] = array(
    'module' => 'contact',
    'title' => _MD_CONTACT_TITLE,
    'table' => 'contact',

    'list_limit' => 4,
    'default_sort' => 'd_id',

    'column' => array(

    array('name' => 'name',
        'title' => _MD_CONTACT_NAME,
        'type' => PUMPFORM_TEXT,
        'required' => 0,
        'visible' => 1,
        'registable' => 1,
        'editable' => 1,
        'list_visible' => 1,
        'minlength' => 1,
        'maxlength' => 256),
    array('name' => 'email',
        'title' => _MD_CONTACT_EMAIL,
        'type' => PUMPFORM_EMAIL,
        'required' => 0,
        'visible' => 1,
        'registable' => 1,
        'editable' => 1,
        'list_visible' => 1,
        'minlength' => 1,
        'maxlength' => 256),
    array('name' => 'body',
        'title' => _MD_CONTACT_BODY,
        'type' => PUMPFORM_TEXTAREA,
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
