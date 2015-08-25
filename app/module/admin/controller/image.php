<?php

require_once PUMPCMS_APP_PATH . '/module/page/model/page_model.php';

class admin_image extends PC_Controller {
    public function __construct() {

		PC_Util::redirect_if_not_site_admin();
		
		PC_Util::include_language_file('page');

		$this->_flg_scaffold = true;
		$this->_module = 'image';
		$this->_table = 'image';
    }
}


