<?php

class note_index extends PC_Controller {
    var $list = [];
    
    public function __construct() {

		PC_Util::redirect_if_not_site_admin();

		$this->_flg_scaffold = true;
		$this->_module = 'note';
		$this->_table = 'note';
    }
    
    public function index() {
	$ormap = PumpORMAP_Util::get('note', 'note');
	$this->list = $ormap->get_list('', 0, 100, 'mod_time');
        $this->render('index');
    }
}
