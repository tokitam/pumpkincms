<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';

class user_index extends PC_Controller {
	public function index() {

		if (isset($_POST['login'])) {
			$user_model = new user_model();
			
			$user_model->login();
		} else {
		    UserInfo::reload();
		}
	    
		$this->render();
	}

	public function confirm() {
		$this->render();
	}

}

