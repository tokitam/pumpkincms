<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';
require_once PUMPCMS_APP_PATH . '/module/user/class/oauth_util.php';

class user_index extends PC_Controller {
	var $oauth_tag;

	public function index() {

		if (isset($_POST['login'])) {
			$user_model = new user_model();
			
			$user_model->login();
		} else {
		    UserInfo::reload();
		}

		$this->oauth_tag = OAuth_util::get_tag();

		$this->render();
	}

	public function confirm() {
		$this->render();
	}

}
