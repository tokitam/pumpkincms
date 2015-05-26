<?php

class fileuptest_index extends PC_Controller {
    public function __construct() {

    	if (UserInfo::is_master_admin() == false) {
    		PC_Util::redirect_top();
    	}

		PumpForm::$redirect_url = PC_Config::url() . '/fileuptest/';

		$this->_flg_scaffold = true;
		$this->_module = 'fileuptest';
		$this->_table = 'fileuptest';
    }
}
