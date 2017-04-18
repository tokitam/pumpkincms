<?php

class index_loadjs extends PC_Controller {
    public function index() {
	    
	header('Content-type: text/javascript; charset: UTF-8');

	$module = $_GET['module'];
	$file = $_GET['file'];
	$module = preg_replace('@[^0-9A-Za-z\-.]@', '', $module);
	$file = preg_replace('@[^0-9A-Za-z\-.]@', '', $file);
	$path = PUMPCMS_APP_PATH . '/module/' . $module . '/js/' . $file;

	if (is_readable($path)) {
	    readfile($path);
	}
	exit();
    }
}

