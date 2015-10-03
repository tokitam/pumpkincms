<?php

class fileuptest_index extends PC_Controller {
    public function __construct() {

		PC_Util::redirect_if_not_site_admin();

		PumpForm::$redirect_url = PC_Config::url() . '/fileuptest/';

		$this->_flg_scaffold = true;
		$this->_module = 'fileuptest';
		$this->_table = 'fileuptest';
    }
}
