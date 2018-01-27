<?php

$pumpform_config['system']['config'] = array(
    'module' => 'system',
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

$pumpform_config['system']['site_list'] = array(
    'module' => 'system',
    'title' => 'site_list',
    'table' => 'site_list',
    'column' => array(

        'domain_dir' => array('name' => 'domain_dir',
            'title' => 'domain_dir',
            'type' => PUMPFORM_TEXT,
            'visible' => 1,
            'registable' => 1,
            'editable' => 1,
            'list_visible' => 1,),
        'site_id' => array('name' => 'site_id',
            'title' => 'site_id',
            'type' => PUMPFORM_INT,
            'visible' => 1,
            'registable' => 1,
            'editable' => 1,
            'list_visible' => 1,),
    ),
);

$pumpform_config['system']['site_config'] = array(
    'module' => 'system',
    'title' => 'site_config',
    'table' => 'site_config',
    'column' => array(

        'theme' => array('name' => 'theme',
            'title' => 'theme',
            'type' => PUMPFORM_TEXT,
            'visible' => 1,
            'registable' => 1,
            'editable' => 1,
            'list_visible' => 1,),
        'db_no' => array('name' => 'db_no',
            'title' => 'db_no',
            'type' => PUMPFORM_INT,
            'visible' => 1,
            'registable' => 1,
            'editable' => 1,
            'list_visible' => 1,),
    ),
);


