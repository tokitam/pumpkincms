<?php

class admin_image extends PC_Controller {
    public function __construct() {
        global $pumpform_config; 

        PC_Util::redirect_if_not_site_admin();

        $this->_flg_scaffold = true;
        $this->_module = 'image';
        $this->_table = 'image';

        PumpFormConfig::load_config($this->_module);

        $pumpform_config['image']['image']['column']['width']['editable'] = 0;
        $pumpform_config['image']['image']['column']['width']['registable'] = 0;
        $pumpform_config['image']['image']['column']['height']['editable'] = 0;
        $pumpform_config['image']['image']['column']['height']['registable'] = 0;
    }
}
