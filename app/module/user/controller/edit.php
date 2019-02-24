<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';
require_once PUMPCMS_APP_PATH . '/module/user/class/user_util.php';

class user_edit extends PC_Controller {
    public function __construct() {
        $this->_flg_scaffold = true;
        $this->_module = 'user';
        $this->_table = 'user';

        PumpForm::$delete_post_process = function() {
            PC_Config::set('delete_post_redirect', PC_Config::url());
            $user_id = PC_Config::get('dir4');
            User_Util::delete_user($user_id);
            ActionLog::log(ActionLog::USER_DELETE);
            $user_model = new user_model();
            $user_model->logout();
        };
    }

    public function index() {
        if (UserInfo::is_logined() == false) {
            PC_Util::redirect_top();
        }

        $method = 'edit';
        PumpForm::$target_id = UserInfo::get_id();
        PumpForm::$redirect_url = PC_Config::url() . '/user/';
        PumpForm::$call_after_update = function() {
            UserInfo::reload();
        };

        PumpFormConfig::load_config('user');
        PC_Util::include_language_file('user');
        global $pumpform_config;
        unset($pumpform_config['user']['user']['column']['password']['required']);

        unset($pumpform_config['user']['user']['column']['name']);
        unset($pumpform_config['user']['user']['column']['email']);
        unset($pumpform_config['user']['user']['column']['auth']);
        unset($pumpform_config['user']['user']['column']['flg_premium']);
        unset($pumpform_config['user']['user']['column']['payment_type']);

        $func = PC_Config::get('user_edit_index_unset_hook');
        if (!empty($func)) {
            $func();
        }


        $this->scaffold($this->_module, $this->_table, $method);
/*
        if (@$_POST['name']) {
            // 更新後に以下のコードを実行してほしい
            // が、リダイレクトして飛んでいる
            $uesr_model = new User_Model();
            $user = $user_model->get_user_by_id(UserInfo::get_id());
            var_dump($user);exit();
            $_SESSION['pump_'. PC_Config::get('site_id')]['user'] = $user;
            UserInfo::reset();
        }
*/
    }
}



