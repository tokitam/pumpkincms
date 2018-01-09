<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';
require_once PUMPCMS_APP_PATH . '/module/user/model/temp_model.php';
require_once PUMPCMS_APP_PATH . '/module/user/class/oauth_util.php';

class user_register extends PC_Controller {
    const MULTI_SITE_TYPE_DIRECTORY = 0;
    const MULTI_SITE_TYPE_SUB_DOMAIN = 1;

    public $error = null;
        var $oauth_tag;
    
    public function index() {
        if (PC_Config::get('allow_register') != 1) {
            PC_Util::redirect_top();
        }

        if (UserInfo::is_logined()) {
            PC_Util::redirect_top();
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
        
        $this->oauth_tag = OAuth_util::get_tag();
        
        if (SiteInfo::get_site_id() == 1) {
            PumpFormConfig::load_config('user');
            global $pumpform_config;

            $multi_site_name =     array('name' => 'multi_site_name',
                                         'title' => 'multi_site_name',
                                         'type' => PUMPFORM_TEXT,
                                         'required' => 1,
                                         'visible' => 1,
                                         'registable' => 1,
                                         'editable' => 1,
                                         'list_visible' => 1,);
            $pumpform_config['user']['user']['column']['multi_site_name'] = $multi_site_name;
        }

        $this->render();
    }
}

