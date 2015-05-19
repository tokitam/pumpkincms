<?php

class admin_config extends PC_Controller {
    public function __construct() {

		if (UserInfo::is_site_admin() == false) {
			PC_Util::redirect(PC_Config::get('base_url') . '/');
		}

		$this->_flg_scaffold = true;
		$this->_module = 'admin';
		$this->_table = 'config';

		PumpForm::$add_pre_process = function() {
			echo ' OK ';
			exit();
		};

		PumpForm::$edit_pre_process = function() {
			echo ' OK ';
			exit();
		};

		PumpForm::$edit_load_process = function($target_id) {
			return array(
				'title' => 'site title',
				'description' => 'desc name',
			);
		};
    }

    public function index() {
    	// do nothing
    }
}
