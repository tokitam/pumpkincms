<?php

//require_once PUMPCMS_SYSTEM_PATH . '/util.php';
require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';

class OAuth_google_Model extends PC_Model {

    function __construct() {
        $this->table_name = 'user_google';
    }
    
    function register($user_id, $google_id, $access_token, $name, $given_name, $family_name, $link, $picture, $gender) {
        
        $db = PC_DBSet::get();
        
        $sql = 'INSERT INTO ' . $db->prefix($this->table_name);
        $sql .= ' ( site_id, user_id, google_id, access_token, name, given_name, family_name, link, picture, gender, ';
        $sql .= ' reg_time, mod_time, reg_user, mod_user) ';
        $sql .= ' VALUES ( ';
        $sql .= intval(SiteInfo::get_site_id()) . ', ';
        $sql .= intval($user_id) . ', ';
        $sql .= $db->escape(PC_Util::mb_truncate($google_id, 128)) . ', ';
        $sql .= $db->escape(PC_Util::mb_truncate($access_token, 256)) . ', ';
        $sql .= $db->escape(PC_Util::mb_truncate($name, 128)) . ', ';
        $sql .= $db->escape(PC_Util::mb_truncate($given_name, 128)) . ', ';
        $sql .= $db->escape(PC_Util::mb_truncate($family_name, 128)) . ', ';
        $sql .= $db->escape(PC_Util::mb_truncate($link, 256)) . ', ';
        $sql .= $db->escape(PC_Util::mb_truncate($picture, 256)) . ', ';
        $sql .= $db->escape(PC_Util::mb_truncate($gender, 16)) . ', ';
        $sql .= time();
        $sql .= ',  0, 0, 0 )';
        
        $db->query($sql);
    }

    function get_user($google_id) {
        $db = PC_DBSet::get();
        $google_id = $db->escape($google_id);

        $sql = ' SELECT * FROM ' . $db->prefix($this->table_name);
        $sql .= sprintf(' WHERE site_id = %d AND google_id = %s ', SiteInfo::get_site_id(), $google_id);
        $sql .= ' ORDER BY id DESC ';
        $sql .= ' LIMIT 1 OFFSET 0 ';

        return $db->fetch_row($sql);
    }

    function get_user_by_user_id($user_id) {
        $db = PC_DBSet::get();

        $sql = ' SELECT * FROM ' . $db->prefix($this->table_name);
        $sql .= sprintf(' WHERE site_id = %d AND user_id = %d ', SiteInfo::get_site_id(), $user_id);
        $sql .= ' ORDER BY id DESC ';
        $sql .= ' LIMIT 1 OFFSET 0 ';

        return $db->fetch_row($sql);
    }

    function login($user_id) {
        if (! empty($user_id)) {
            $user_model = new user_model();
            $user = $user_model->get_user_by_id($user_id);
            $user_model->update_last_login_time($user_id);
            $_SESSION['pump_'. PC_Config::get('site_id')]['user'] = $user;
            $user_model->load_rel_user($user_id);
            PC_Notification::set(_MD_USER_LOGINED);
            ActionLog::log(ActionLog::LOGIN);
            PC_Util::redirect_top();
        }
    }
}
