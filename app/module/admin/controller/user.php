<?php

class admin_user extends PC_Controller {
    public function __construct() {

    	if (UserInfo::is_site_admin() == false) {
			PC_Util::redirect_top();
		}

		$this->_flg_scaffold = true;
		$this->_module = 'user';
		$this->_table = 'user';
    }
}
