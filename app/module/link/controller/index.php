<?php

class link_index extends PC_Controller {
    public function __construct() {

	//PC_Util::redirect_if_not_site_admin();

	$this->_flg_scaffold = true;
	$this->_module = 'link';
	$this->_table = 'link';
	
	PC_Render::add_javascript('/js/select2/js/select2.full.js');
	PC_Render::add_css('/js/select2/css/select2.css');
    }
    
    public function detail() {
	preg_match('@/([0-9]+)@', $_SERVER['REQUEST_URI'], $r);
	if (isset($r[1])) {
	    PC_Config::set('og::url', PC_Config::url() . '/link/' . intval($r[1]));
	}
	parent::detail();
    }
    
    public function add() {
	parent::add();
    }
}
