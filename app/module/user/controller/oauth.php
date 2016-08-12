<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';
require_once PUMPCMS_APP_PATH . '/module/user/model/temp_model.php';
require_once PUMPCMS_APP_PATH . '/module/user/class/oauth_util.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpmailer.php';

class user_oauth extends PC_Controller {
	public $oauth;
	public $type;

	public function index() {
	    unset($_SESSION['oauth_type']);
		$oauth = Oauth_util::load_oauth_class();
		$oauth->get();
	}

	public function callback() {
		$this->oauth = Oauth_util::load_oauth_class();
		$this->oauth->callback();
		$user = $this->oauth->get_user();

		if (! empty($user)) {
			// registered
			$this->oauth->login($user);
		}

	    PC_Debug::log('oauthdebug1', __FILE__, __LINE__);
	    if (PC_Config::get('sns_register_no_mail')) {
	    PC_Debug::log('oauthdebug2', __FILE__, __LINE__);
		$sns_user = array();
		$sns_user['name'] = $this->oauth->get_name();
		$user_model = new user_model();
		$user_id = $user_model->register($sns_user);
		
		$this->oauth->register($user_id);
		
		$sns_user = $this->oauth->get_user();
		$icon_url = $this->oauth->get_icon_url($sns_user);

		$buf = file_get_contents($icon_url);
		$tmpfile = tempnam(sys_get_temp_dir(), 'pump_ex_image');
		file_put_contents($tmpfile, $buf);
		
		$pumpimage = new PumpImage();
		$image_id = $pumpimage->upload(null, $tmpfile, 'image/jpeg');
		$user_model->update_image_id($user_id, $image_id);
		
		unlink($tmpfile);
		
		$this->oauth->login($sns_user);
		
		exit();
	    }
	    
		$this->type = '';
		if (! empty($_GET['type'])) {
			$this->type = $_GET['type'];
		}
		if (! empty($_POST['type'])) {
			$this->type = $_POST['type'];
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
		// name
		if (@$_POST['name'] == '') {
			// no good data
			die();
		}

		$this->oauth = Oauth_util::load_oauth_class();

		if ($this->oauth->input_email && empty($_POST['email'])) {
			die();
		}

		if ($this->oauth->input_password && empty($_POST['password'])) {
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
		    $user_model->_check_password = $this->oauth->input_password;
		    $user_model->_check_email = $this->oauth->input_email;
		    $this->error = $user_model->register_validate();
		    
		    if (isset($_POST['type'])) {
			$this->type = $_POST['type'];
		    }

		    if (count($this->error) == 0) {

				$temp_model = new Temp_Model();
				$code = mt_rand(1000, 9999) . uniqid();
				$insert_id = $temp_model->register(@$_POST['name'], @$_POST['email'], @$_POST['password'], $code, @$_POST['type']);
				$type = @$_POST['type'];
				$type = preg_replace('/[^0-9A-Za-z]/', '', $type);
				$register_url = PC_Config::get('base_url') . '/user/verifi/?type=' . $type . '&id=' . $insert_id . '_' . $code;

				if ($this->oauth->input_email) {
					$to = $_POST['email'];
					$subject = _MD_USER_REGISTER_TITLE;
					$message = _MD_USER_REGISTER_MESSAGE;
						  
					$message = preg_replace('/\[register_url\]/', $register_url, $message);

					$admin_mail = PC_Config::get('from_email');
					$admin_subject = '[admin info] ' . $subject;
					$admin_message = "[admin info]\r\n" . $message;

					if (PC_Config::get('mail_function') == 'phpmailer') {
						$mailer = new PumpMailer();
						$mailer->send($to, $subject, $message);
						$mailer->send($admin_mail, $admin_subject, $admin_message);
					} else {
						PC_Util::mail($to, $subject, $message);
						PC_Util::mail($admin_mail, $admin_subject, $admin_message);
					}
							
					ActionLog::log(ActionLog::REGISTER_TEMP);

					$this->render('register_do');
					return;
				} else {
				    $user = array();
				    $user['name'] = $_POST['name'];
				    $user['email'] = $this->oauth->get_email();
				    
				    // register pumpkincms uesr
				    $user_id = $user_model->register($user);
				    ActionLog::log(ActionLog::REGISTER_FINISH);
				    $this->message = _MD_USER_REGISTER_OK;
				    
				    // register sns user 
				    $this->oauth->register($user_id);
				    // login
				    $sns_user = $this->oauth->get_user();
				    PC_Notification::set(_MD_USER_LOGINED);
				    unset($_SESSION['oauth_type']);
				    ActionLog::log(ActionLog::LOGIN);
				    $this->oauth->login($sns_user);
				    
				    $this->render('verifi');
				    return;
				}
				    
		    }
		}
		
		$this->render('sns_register');
    }
}
