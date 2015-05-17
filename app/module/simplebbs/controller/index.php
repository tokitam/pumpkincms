<?php

class simplebbs_index extends PC_Controller {
    public function __construct() {

    	if (UserInfo::is_master_admin() == false) {
    		PC_Util::redirect(PC_Config::url() . '/');
    	}

		//PumpForm::$redirect_url = PC_Config::url() . '/simplebbs/';

		$this->_flg_scaffold = true;
		$this->_module = 'simplebbs';
		$this->_table = 'simplebbs';
    }
}



