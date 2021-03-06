<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';
require_once PUMPCMS_SYSTEM_PATH. '/version.php';

class admin_index extends PC_Controller {
    var $message;
    var $list;

    public function index() {
        PC_Util::redirect_if_not_site_admin();

        $this->message = array();

        $user_model = new User_Model();

        if (UserInfo::is_master_admin()) {
            array_unshift($this->message, _MD_ADMIN_ADMIN_MODE);
            //$user_model->admin_mode(true);
        } else {
            array_unshift($this->message, _MD_ADMIN_NO_AUTH);
        }

        $actionlog = PumpORMAP_Util::get('user', 'actionlog');
        $this->list = $actionlog->get_list('', 0, 20, 'id', true);

        $this->render('message');

    }

    public function phpinfo() {
        PC_Util::redirect_if_not_site_admin();

        phpinfo();
    }
}

