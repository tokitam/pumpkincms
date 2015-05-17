<?php

require_once PUMPCMS_APP_PATH . '/module/blog/class/blogdefine.php';
require_once PUMPCMS_SYSTEM_PATH . '/xml_parser.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumprssparser.php';

class blog_index extends PC_Controller {
    public function __construct() {
		$this->_flg_scaffold = true;
		$this->_module = 'blog';
		$this->_table = 'blog';

		if (PC_Util::is_admin_dir() == false) {
			PumpForm::$where = 'status = ' . BlogDefine::OPEN;
		}

		if (PC_Config::get('blog_id')) {
			if (PumpForm::$where) {
				PumpForm::$where .= ' AND ';
			}
			PumpForm::$where .= ' blog_id = ' . intval(PC_Config::get('blog_id'));
		}
    }
    
    public function feed2widget() {

	    $rssparser = new PumpRssParser();

	    if (@$_GET['url'] && PC_Util::is_url($_GET['url'])) {
	    	$url = $_GET['url'];
	    } else {
	    	return;
	    }

    	$rssparser->parse($url);

	    if ($rssparser->is_successful()) {
    	    $this->_data['feed'] = $rssparser->result['items'];
    	} 

    	$this->render('feed2widget');
    	exit();
    }
}

