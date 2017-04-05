<?php

class link_index extends PC_Controller {
    public function __construct() {

		PC_Util::redirect_if_not_site_admin();

		$this->_flg_scaffold = true;
		$this->_module = 'link';
		$this->_table = 'link';
	
	PC_Render::add_javascript('/js/select2/js/select2.full.js');
	PC_Render::add_css('/js/select2/css/select2.css');
    }
    
    public function add2() {
	var_dump($_POST);
	exit();
    }
}
