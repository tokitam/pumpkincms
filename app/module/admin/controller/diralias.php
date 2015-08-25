<?php

require_once PUMPCMS_APP_PATH . '/module/page/model/page_model.php';

class admin_diralias extends PC_Controller {
    public function __construct() {

		PC_Util::redirect_if_not_site_admin();
		
		$this->_flg_scaffold = true;
		$this->_module = 'page';
		$this->_table = 'diralias';
    }
}



