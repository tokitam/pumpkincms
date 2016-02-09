<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';

class user_index extends PC_Controller {
	var $oauth_tag;

	public function index() {

		if (isset($_POST['login'])) {
			$user_model = new user_model();
			
			$user_model->login();
		} else {
		    UserInfo::reload();
		}

		$this->oauth_tag = array();
	    
		if (true) { // twitter
			require_once PUMPCMS_APP_PATH . '/module/user/plugin/twitter/oauth.php';
			$oauth = new OAuth();

			//require_once PUMPCMS_APP_PATH . '/module/user/plugin/twitter/oauth.php';
			//$oauth = new OAuth();
		} else {
			// plugin not found
		}

		array_push($this->oauth_tag, $oauth->get_tag()); 

		$this->render();
	}

	public function confirm() {
		$this->render();
	}

}

