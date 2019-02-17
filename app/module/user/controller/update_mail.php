<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';

class user_update_mail extends PC_Controller {
    public function __construct() {
        //PumpForm::$redirect_url = PC_Config::url() . '/simplebbs/';

        $this->_flg_scaffold = true;
        $this->_module = 'user';
        $this->_table = 'temp_update_mail';
    }

    public function index() {
        if (UserInfo::is_logined() == false) {
            PC_Util::redirect_top();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            PumpForm::$add_pre_process = function() {
                $_POST['user_id'] = UserInfo::get_id();
                $_POST['flg_processed'] = 0;
                $_POST['code'] = PC_Util::random_code(30);
                PC_Config::set('update_mail_code', $_POST['code']);

            };
            PumpForm::$add_post_process = function() {
                $to = $_POST['email'];
                $subject = _MD_USER_UPDATE_MAIL_TITLE;
                $message = _MD_USER_UPDATE_MAIL_MESSAGE;

                $code = PC_Config::get('update_mail_code');
                $update_mail_url = PC_Config::url() . '/user/update_mail/confirm/?code=' . $code;

                $subject = preg_replace('/\[site_title\]/', PC_Config::get('site_title'), $subject);
                $message = preg_replace('/\[update_mail_url\]/', $update_mail_url, $message);

                // メール送信
                PC_Util::mail($to, $subject, $message);

                $url = PC_Config::url() . '/user/update_mail/send';
                PC_Util::redirect($url);
                return;
            };

            parent::add();
            return;
        }

        $method = 'add';
/*
        PumpForm::$target_id = UserInfo::get_id();
        PumpForm::$redirect_url = PC_Config::url() . '/user/';
        PumpForm::$call_after_update = function() {
            UserInfo::reload();
        };
*/
        PumpFormConfig::load_config('user');
        PC_Util::include_language_file('user');
        global $pumpform_config;

        unset($pumpform_config['user']['temp_update_mail']['column']['user_id']);
        unset($pumpform_config['user']['temp_update_mail']['column']['flg_processed']);
        unset($pumpform_config['user']['temp_update_mail']['column']['code']);

        $this->scaffold($this->_module, $this->_table, $method);

    }

    public function send() {
        echo _MD_USER_SENT;
    }

    public function confirm() {
        if (UserInfo::is_logined() == false) {
            //PC_Util::redirect_top();
            echo 'not login';
            return;
        }

        if (empty($_GET['code'])) {
            PC_Util::redirect_top();
        }

        $code = $_GET['code'];

        $ormap_update_mail = PumpORMAP_Util::get('user', 'temp_update_mail');
        $ormap_user = PumpORMAP_Util::get('user', 'user');
        $db = PC_DBSet::get();

        $where = sprintf(" user_id = %d AND code = %s AND flg_processed = 0 ", UserInfo::get_id(), $db->escape($code));
        $list = $ormap_update_mail->get_list($where, 0, 1, 'id', true);

        if (empty($list) || empty($list[0])) {
            echo _MD_USER_UPDATE_MAIL_ERROR_CODE;
            exit();
        }

        $temp = $list[0];

        $ormap_user->update(UserInfo::get_id(), '', ['email' => $temp['email']]);
        $where = ' user_id = ' . UserInfo::get_id();
        $ormap_update_mail->update(null, $where, ['flg_processed' => 1]);
        echo _MD_USER_UPDATED_MAIL;
    }
}
