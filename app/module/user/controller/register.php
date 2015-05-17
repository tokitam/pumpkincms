<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';
require_once PUMPCMS_APP_PATH . '/module/user/model/temp_model.php';

class user_register extends PC_Controller {
    public $error = null;
	
    public function index() {
	    
	if (UserInfo::is_logined()) {
	    PC_Util::redirect(PC_Config::url() . '/');
	}
	
	$this->error = array();
	
	    
	if (isset($_POST['post'])) {
			
	    $user_model = new user_model();
	    $this->error = $user_model->register_validate();

	    if (count($this->error) == 0) {

		$temp_model = new Temp_Model();
		$code = mt_rand(1000, 9999) . uniqid();
		$insert_id = $temp_model->register($_POST['name'], $_POST['email'], $_POST['password'], $code, @$_POST['type']);
		
		$register_url = PC_Config::get('base_url') . '/user/verifi/?id=' . $insert_id . '_' . $code;

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
	
	$this->render();
    }
}

