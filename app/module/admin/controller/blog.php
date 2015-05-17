<?php

class admin_blog extends PC_Controller {
    public function __construct() {
		if (UserInfo::is_site_admin() == false) {
			PC_Util::redirect(PC_Config::url() . '/');
		}

		PumpForm::$redirect_url = PC_Config::url() . '/admin/blog/';
	
		$this->_flg_scaffold = true;
		$this->_module = 'blog';
		$this->_table = 'blog';
    }
}
