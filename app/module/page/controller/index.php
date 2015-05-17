<?php

require_once PUMPCMS_APP_PATH . '/module/page/model/page_model.php';

class page_index extends PC_Controller {
    var $page_data; 
    var $file;

    public function index() {

		$page_model = new page_model();
		$this->page_data = $page_model->get_page(SiteInfo::get('dir'));

		$this->mkdir();

		$this->file = $this->get_dir() . '/' . urlencode($this->page_data['dir_name']) . '.php';
		PC_Debug::log('file:' . $this->file, __LINE__, __LINE__);
		file_put_contents($this->file, $this->page_data['body']);

		$this->render();
	    
    }

    public function mkdir() {
    	$dir = PUMPCMS_APP_PATH . '/cache/page';
    	if (is_dir($dir) == false) {
    		mkdir($dir);
    	}

    	$dir .= '/' . PC_Config::get('site_id');
    	if (is_dir($dir) == false) {
    		mkdir($dir);
    	}
    }

    public function get_dir() {
    	$dir = PUMPCMS_APP_PATH . '/cache/page/' . PC_Config::get('site_id');
    	return $dir;
    }
}
