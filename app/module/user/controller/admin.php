<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';

class user_admin extends PC_Controller {
    var $message;
    public function index() {

        $this->message = array();

        $user_model = new User_Model();
        
        if (UserInfo::is_master_admin()) {
            array_unshift($this->message, _MD_USER_ADMIN_MODE);
            //$_SESSION['admin_mode'] = 1;
            //UserInfo::admin_mode(true);
            $user_model->admin_mode(true);
        } else {
            array_unshift($this->message, _MD_USER_NO_AUTH);
        }
    
        $this->render('message');
    }
}
