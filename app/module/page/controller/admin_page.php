<?php

require_once PUMPCMS_APP_PATH . '/module/page/model/page_model.php';

class page_admin_page extends PC_Controller {
    public function __construct() {
		$this->_flg_scaffold = true;
		$this->_module = 'page';
		$this->_table = 'page';
    }
}


