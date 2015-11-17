<?php

class admin_user extends PC_Controller {
    public function __construct() {
        global $pumpform_config; 

        PC_Util::redirect_if_not_site_admin();
            
        $this->_flg_scaffold = true;
        $this->_module = 'user';
        $this->_table = 'user';
        
        PumpFormConfig::load_config($this->_module, $this->_table);
        $pumpform_config['user']['user']['column']['password']['required'] = 0;
    }
}
