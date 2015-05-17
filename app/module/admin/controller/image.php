<?php

require_once PUMPCMS_APP_PATH . '/module/page/model/page_model.php';

class admin_image extends PC_Controller {
    public function __construct() {

		if (UserInfo::is_site_admin() == false) {
			PC_Util::redirect(PC_Config::url() . '/');
		}

		PC_Util::include_language_file('page');

		$this->_flg_scaffold = true;
		$this->_module = 'image';
		$this->_table = 'image';
    }
}


