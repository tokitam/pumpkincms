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

    public function check_id() {
    	$id = @$_GET['id'];
    	$db = PC_DBSet::get();
		$ormap = PumpORMAP_Util::get('user', 'user');
		$list = $ormap->get_list("name = " . $db->escape($id));

		$ret = array();
		if (is_array($list) && 0 < count($list)) {
			$ret['status'] = 0;
			$ret['exists'] = 1;
		} else {
			$ret['status'] = 0;
			$ret['exists'] = 0;
		}

		header("Content-Type: application/json; charset=utf-8");
		echo json_encode($ret, JSON_PRETTY_PRINT);
		exit();
    }
}
