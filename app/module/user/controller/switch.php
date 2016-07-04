<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';
require_once PUMPCMS_APP_PATH . '/module/user/class/oauth_util.php';

class user_switch extends PC_Controller {

	public function index() {
		$switch_user_id = intval($_GET['user_id']);
		$user_model = new User_Model();
		$user_model->switch_user($switch_user_id);
	}
}
