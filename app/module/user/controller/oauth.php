<?php

require_once PUMPCMS_APP_PATH . '/module/user/plugin/twitter/oauth.php';

class user_oauth extends PC_Controller {
	public function index() {
		$oauth = new OAuth();

		$oauth->get();
	}

	public function callback() {
		$oauth = new OAuth();

		$oauth->callback();

		$this->render('sns_register');
	}
}
