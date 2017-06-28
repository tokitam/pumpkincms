<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';
require_once PUMPCMS_APP_PATH . '/module/user/class/oauth_util.php';

class user_admin_switch extends PC_Controller {
    public function index() {
        if (empty($_SESSION['pump_'. PC_Config::get('site_id')]['admin_user'])) {
            PC_Util::redirect_top();
        }
 
        $admin_user = $_SESSION['pump_'. PC_Config::get('site_id')]['admin_user'];
        $_SESSION['pump_'. PC_Config::get('site_id')]['user'] = $admin_user;
        unset($_SESSION['pump_'. PC_Config::get('site_id')]['admin_user']);

        PC_Util::redirect_top();
    }
}
