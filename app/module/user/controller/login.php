<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';

class user_login extends PC_Controller {
	var $error = array();
	
	public function index() {

		$this->error = array();
		
		if (isset($_POST['login'])) {
			$user_model = new user_model();
			
			$this->error = $user_model->login();
		}
	
		ActionLog::log(ActionLog::LOGIN);

		$this->render('login');
	}
}

