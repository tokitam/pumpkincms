<?php

class image_index extends PC_Controller {
    public function __construct() {
        PC_Util::redirect_if_not_site_admin();

        $this->_flg_scaffold = true;
        $this->_module = 'image';
        $this->_table = 'image';
    }
}



