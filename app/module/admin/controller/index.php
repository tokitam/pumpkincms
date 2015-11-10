<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';

class admin_index extends PC_Controller {
    var $message;
    var $list;

	public function index() {

		if (UserInfo::is_site_admin() == false) {
			PC_Notification::set(_MD_USER_LOGOUT);
			PC_Util::redirect_top();
		}

	    $this->message = array();

	    $user_model = new User_Model();
	    
	    if (UserInfo::is_master_admin()) {
			array_unshift($this->message, _MD_ADMIN_ADMIN_MODE);
			//$user_model->admin_mode(true);
	    } else {
			array_unshift($this->message, _MD_ADMIN_NO_AUTH);
	    }

	    $actionlog = PumpORMAP_Util::get('user', 'actionlog');
	    $this->list = $actionlog->get_list('', 0, 20, 'id', true);
	
		$this->render('message');

	}
}

