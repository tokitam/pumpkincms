<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';

class user_logout extends PC_Controller {
	public function index() {
		$user_model = new user_model();
		
		$user_model->logout();
				
		$this->render();
	}
}

