<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';
require_once PUMPCMS_APP_PATH . '/module/user/class/oauth_util.php';

class user_login extends PC_Controller {
	var $error = array();
	var $oatuh_tag;
	
	public function index() {

		$this->error = array();
		
		if (isset($_POST['login'])) {
			$user_model = new user_model();
			$this->oauth_tag = OAuth_util::get_tag();

			$this->error = $user_model->login();
		}
	
		ActionLog::log(ActionLog::LOGIN);

		$this->render('login');
	}
}

