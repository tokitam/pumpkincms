<?php

class admin_blog extends PC_Controller {
    public function __construct() {
    	
		PC_Util::redirect_if_not_site_admin();

		PumpForm::$redirect_url = PC_Config::url() . '/admin/blog/';
	
		$this->_flg_scaffold = true;
		$this->_module = 'blog';
		$this->_table = 'blog';
    }
}
