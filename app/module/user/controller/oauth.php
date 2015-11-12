<?php

require_once PUMPCMS_APP_PATH . '/module/user/plugin/twitter/oauth.php';

class user_oauth extends PC_Controller {
	public function index() {
		$oauth = new OAuth();

		$oauth->get();
	}

	public function oob() {
		echo 'oob';
		exit();
	}
}
