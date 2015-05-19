<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';
require_once PUMPCMS_APP_PATH . '/module/user/model/temp_model.php';

class user_verifi extends PC_Controller {
    public $error = null;
    var $message = '';
	
    public function index() {
      
        if (isset($_GET['id']) == false) {
	    $this->message = _MD_USER_REGISTER_NO_ID;
	    $this->render();
	    return;
	}
	    
	$user_model = new user_model();
	$temp_model = new temp_model();

	$user = $temp_model->get_user_data($_GET['id']);

	if ($user == false) {
	    $this->message = _MD_USER_REGISTER_NO_DATA;
	    $this->render();
	    return;
	}

	if (@$user['flg_processed']) {
	    $this->message = _MD_USER_REGISTERED;
	    $this->render();
	    return;
	}
    
	$user_model->register($user);
	$db = PC_DBSet::get();
	$user_id = $db->insert_id();
	$temp_model->update_flg_process($_GET['id']);
	    
	$this->message = _MD_USER_REGISTER_OK;
	ActionLog::log(ActionLog::REGISTER_FINISH, '', $user_id);
	    
	$admin_mail = PC_Config::get('from_email');
	$admin_subject = '[admin info] register finish';
	$admin_message = "[admin info]\r\n\r\nuser: " . $user['name'];

	PC_Util::mail($admin_mail, $admin_subject, $admin_message);

	$this->render();
    }
}