<?php

class simplebbs_index extends PC_Controller {
    public function __construct() {
        PC_Util::redirect_if_not_site_admin();
        $this->set_scaffold('simplebbs', 'simplebbs');
    }
}
