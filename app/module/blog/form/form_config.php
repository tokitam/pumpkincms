<?php

require_once PUMPCMS_APP_PATH . '/module/blog/class/blogdefine.php';
require_once PUMPCMS_APP_PATH . '/module/blog/class/blogutil.php';

$pumpform_config['blog']['blog'] = array(
    'module' => 'blog',
    'title' => _MD_BLOG,
    'table' => 'blog',

    'detail_php' => 'detail',
    'list_php' => 'list',
    'default_sort' => 'd_id',

    'column' => array(

    'blog_id' => array('name' => 'blog_id',
    	'title' => 'blog_id',
    	'type' => PUMPFORM_SELECT,
	      'required' => 0,
	      'visible' => 1,
	      'registable' => 1,
	      'editable' => 1,
	      'list_visible' => 1,
	      'option' => BlogUtil::get_dir_list(),
	      'default' => 1,
    	),
	'status' => array('name' => 'status',
	      'title' => _MD_BLOG_STATUS,
	      'type' => PUMPFORM_SELECT,
	      'required' => 0,
	      'visible' => 1,
	      'registable' => 1,
	      'editable' => 1,
	      'list_visible' => 1,
	      'option' => array(
	      	BlogDefine::PENDING => '非公開',
	      	BlogDefine::OPEN => '公開',
	      	),
	      'default' => BlogDefine::PENDING,
	      ),

	'title' => array('name' => 'title',
	      'title' => _MD_BLOG_TITLE,
	      'type' => PUMPFORM_TEXT,
	      'placeholder' => _MD_BLOG_TITLE,
	      'required' => 1,
	      'visible' => 1,
	      'registable' => 1,
	      'editable' => 1,
	      'list_visible' => 1,
	      'minlenth' => 1,
	      'maxlength' => 256),
	'body' => array('name' => 'body',
	      'title' => _MD_BLOG_BODY,
	      'type' => PUMPFORM_TINYMCE,
	      'required' => 0,
	      'visible' => 1,
	      'registable' => 1,
	      'editable' => 1,
	      'list_visible' => 1,
	      'minlenth' => 0,
	      'maxlength' => 20000),


	
	),
);

/*
$pumpform_config['blog']['rsscache'] = array(
    'module' => 'blog',
    'title' => _MD_BLOG_RSSCACHE,
    'table' => 'rsscache',

    'column' => array(
        array('name' => 'id',
	      'type' => PUMPFORM_PRIMARY_ID,
	      'visible' => 0,
	      'list_visible' => 0),
        array('name' => 'site_id',
              'type' => PUMPFORM_SITE_ID,
              'visible' => 0),
        array('name' => 'reg_time',
              'type' => PUMPFORM_TIME,
              'visible' => 0,
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
		      
	'url' => array('name' => 'url',
	      'title' => _MD_BLOG_STATUS,
	      'type' => PUMPFORM_SELECT,
	      'required' => 0,
	      'visible' => 1,
	      'registable' => 1,
	      'editable' => 1,
	      'list_visible' => 1,
	      'option' => array(
	      	BlogDefine::PENDING => '非公開',
	      	BlogDefine::OPEN => '公開',
	      	),
	      'default' => BlogDefine::PENDING,
	      ),

	'body' => array('name' => 'body',
	      'title' => _MD_BLOG_BODY,
	      'type' => PUMPFORM_TINYMCE,
	      'required' => 0,
	      'visible' => 1,
	      'registable' => 1,
	      'editable' => 1,
	      'list_visible' => 1,
	      'minlenth' => 0,
	      'maxlength' => 20000),
	),
);

*/

