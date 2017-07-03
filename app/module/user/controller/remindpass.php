<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';
require_once PUMPCMS_APP_PATH . '/module/user/model/remindpass_model.php';

class user_remindpass extends PC_Controller {
    public $error = null;
    var $message = array();
    var $sent = false;

    public function index() {

        $this->message = array();

        if (@$_GET['id'] != '') {

            $this->render('remindpassform');
            return;
        }

        if (@$_POST['email'] != '') {
            $user_model = new user_model();
            $remindpass_model = new remindpass_model();
            $user = $user_model->get_user_by_email($_POST['email']);

            if (@$user) {
                // send mail
                array_unshift($this->message, _MD_USER_SENT);

                $code = rand(1000, 9999) . uniqid();
                $insert_id = $remindpass_model->register($user['id'], $user['email'], $code);

                $remindpass = intval($insert_id) . '_' . $code;
                $this->sent = true;

                $this->sendmail($remindpass);
            } else {
                array_unshift($this->message, _MD_USER_EMAIL_NOT_FOUND);
            }
        }

        $this->render();
    }

    public function reset() {
        if (@$_GET['id'] == '') {
            // no id
            array_unshift($this->message, _MD_USER_REMIND_NO_USER);
            $this->render('error');
            return;
        }

        $user_model = new user_model();
        $remind_user = $user_model->get_remindpass_user($_GET['id']);

        if ($remind_user == false) {
            // no user
            array_unshift($this->message, _MD_USER_REMIND_NO_USER);
            $this->render('error');
            return;
        }

        $tmp = explode('_', $_GET['id']);
        $user_id = intval($remind_user['user_id']);
        //	    echo " remind_user " ;
        //var_dump($remind_user);	    
        $user = $user_model->get_user_by_id($user_id);

        if ($user == false) {
            array_unshift($this->message, _MD_USER_REGISTER_NO_DATA);
            $this->render('error');
            return;
        }

        if ($remind_user['reg_time'] < time() - PC_Config::get('remindpass_time')) {
            array_unshift($this->message, _MD_USER_TIME_OVER);
            $this->render('error');
            return;
        }

        if (isset($_POST['new_password'])) {
            $this->message = $user_model->reset_validate();
        } else {
            $this->render('remindpass_reset');
            return;
        }

        if (count($this->message) == 0) {
            // update
            $user_model->update_password($user_id, $_POST['new_password']);
            array_unshift($this->message, _MD_USER_UPDATED_PASSWORD);
            $this->render('remindpass_successful');
            return;
        }

        $this->render('remindpass_reset');
    }

    function sendmail($remindpass_id) {
        $to = $_POST['email'];
        $subject = _MD_USER_REMINDPASS_TITLE;
        $message = _MD_USER_REMINDPASS_MESSAGE;

        $remindpass_url = PC_Config::get('base_url') . '/user/remindpass/reset/?id=' . $remindpass_id;

        //$subject = preg_replace('/\[site_title\]/', PC_Config::get('site_title'), $subject);
        //$subject = preg_replace('/\[base_url\]/', PC_Config::get('base_url'), $subject);
        //$message = preg_replace('/\[site_title\]/', PC_Config::get('site_title'), $message);
        //$message = preg_replace('/\[base_url\]/', PC_Config::get('base_url'), $message);
        $message = preg_replace('/\[remindpass_url\]/', $remindpass_url, $message);

        //mail($to, $subject, $message);

        PC_Util::mail($to, $subject, $message);
    }
}

