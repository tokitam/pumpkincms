<?php

class admin_ad extends PC_Controller {
    public function __construct() {

    	if (UserInfo::is_site_admin() == false) {
			PC_Util::redirect_top();
		}

		PC_Util::include_language_file('shop');
		PumpFormConfig::load_config('shop');
/*
		global $pumpform_config;
		$pumpform_config['shop']['shop']['column']['status']['visible'] = 1;
		$pumpform_config['shop']['shop']['column']['status']['editable'] = 1;
		$pumpform_config['shop']['shop']['column']['status']['registable'] = 1;
		*/
//var_dump($pumpform_config);

		$this->_flg_scaffold = true;
		$this->_module = 'shop';
		$this->_table = 'ad_booking';
    }
}
