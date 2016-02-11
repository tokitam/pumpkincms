<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';
require_once PUMPCMS_APP_PATH . '/module/user/model/temp_model.php';
require_once PUMPCMS_APP_PATH . '/module/user/class/oauth_util.php';

class user_oauth extends PC_Controller {
	public function index() {
		$oauth = Oauth_util::load_oauth_class();
		$oauth->get();
	}

	public function callback() {
		$oauth = Oauth_util::load_oauth_class();
		$oauth->callback();
		$user = $oauth->get_user();

		if (! empty($user)) {
			// registered
			$oauth->login($user);
		}

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

    public function register() {
		// email, password, name
		if (@$_POST['email'] == '' ||
			@$_POST['password'] == '' ||
			@$_POST['name'] == '') {
			// no good data
			die();
		}

		if (PC_Config::get('allow_register') != 1) {
			PC_Util::redirect_top();
		}

		if (UserInfo::is_logined()) {
			PC_Util::redirect_top();
		}
		
		$this->error = array();
		    
		if (isset($_POST['post'])) {
				
		    $user_model = new user_model();
		    $this->error = $user_model->register_validate();

		    if (count($this->error) == 0) {

				$temp_model = new Temp_Model();
				$code = mt_rand(1000, 9999) . uniqid();
				$insert_id = $temp_model->register($_POST['name'], $_POST['email'], $_POST['password'], $code, @$_POST['type']);

				$register_url = PC_Config::get('base_url') . '/user/verifi/?type=twitter&id=' . $insert_id . '_' . $code;

				$to = $_POST['email'];
				$subject = _MD_USER_REGISTER_TITLE;
				$message = _MD_USER_REGISTER_MESSAGE;
					  
				$message = preg_replace('/\[register_url\]/', $register_url, $message);

				$admin_mail = PC_Config::get('from_email');
				$admin_subject = '[admin info] ' . $subject;
				$admin_message = "[admin info]\r\n" . $message;

				PC_Util::mail($to, $subject, $message);
				PC_Util::mail($admin_mail, $admin_subject, $admin_message);
						
				ActionLog::log(ActionLog::REGISTER_TEMP);

				$this->render('register_do');
				return;
				    
		    }
		}
		
		$this->render('sns_register');
    }
}
