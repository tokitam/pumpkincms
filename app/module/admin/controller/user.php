<?php

class admin_user extends PC_Controller {
    public function __construct() {
        global $pumpform_config; 

        PC_Util::redirect_if_not_site_admin();

        $this->_flg_scaffold = true;
        $this->_module = 'user';
        $this->_table = 'user';

        PumpFormConfig::load_config($this->_module, $this->_table);
        $pumpform_config['user']['user']['column']['password']['required'] = 0;
        $pumpform_config['user']['user']['list_php'] = PUMPCMS_APP_PATH . '/module/admin/view/user_list.php';
    }

    public function index() {
        parent::index();
    }

    public function switch_user() {
        if (empty($_GET['user_id']) || is_numeric($_GET['user_id']) == false) {
            PC_Util::redirect_top();
        }

        $user_ormap = PumpORMAP_Util::get('user', 'user');
        $user = $user_ormap->get($_GET['user_id']);

        $before_user = $_SESSION['pump_'. PC_Config::get('site_id')]['user'];
        $_SESSION['pump_'. PC_Config::get('site_id')]['admin_user'] = $before_user;

        UserInfo::set_all($user);
        PC_Util::redirect_top();
    }
}
