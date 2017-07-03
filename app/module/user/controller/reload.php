<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';

class user_reload extends PC_Controller {
    public function index() {

    if (UserInfo::is_logined() == false) {
        echo 'No login';
        exit();
    }
    
    UserInfo::reload();

    if (@$_GET['p'] == 'flg_tel_auth') {
        echo UserInfo::get('flg_tel_auth');
    } else {
        echo 'reloaded';
    }
    exit();
    }
}

