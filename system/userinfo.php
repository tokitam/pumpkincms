<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';

class UserInfo {
    static private $_data = null;
    const AUTH_MASTER_ADMIN = 1;
    const AUTH_SITE_ADMIN = 2;
    
    static function get($key) {
        return self::get_data($key);
    }

    static function set($key, $value) {
        $_SESSION['pump_'. PC_Config::get('site_id')]['user'][$key] = $value;
        self::$_data[$key] = $value;
    }

    static function set_all($tmp) {
        $_SESSION['pump_'. PC_Config::get('site_id')]['user'] = $tmp;
        $_SESSION['user'] = $tmp;
        self::$_data = $value;
    }

    static function get_data($key=false) {
        if (self::$_data == null) {
            self::$_data = @$_SESSION['pump_'. PC_Config::get('site_id')]['user'];
        }

        if ($key == false) {
            return self::$_data;
        } else {
            return @self::$_data[$key];
        }
    }
    
    static function is_loggedin() {
        if (self::get_data()) {
            return true;
        }

        return false;
    }
   
    static function is_logined() {
        return self::is_loggedin();   
    }
   
    static function get_type() {
        return self::get_data('type');
    }

    static function is_master_admin() {
        if (self::is_logined() == false) {
            return false;
        }
        if ((@self::$_data['auth']) & self::AUTH_MASTER_ADMIN) {
            return true;
        }

        return false;
    }

    static function is_site_admin() {
        if (self::is_logined() == false) {
            return false;
        }

        if (self::is_master_admin()) {
            return true;
        }

        if ((@self::$_data['auth']) & self::AUTH_SITE_ADMIN) {
            return true;
        }

        return false;
    }
    
    static function is_admin_mode() {
        if (PC_Config::get('dir1') == 'admin') {
            return true;
        }

        return false;
    }

    static function is_admin_switch() {
        if (isset($_SESSION['pump_'. PC_Config::get('site_id')]['admin_user'])) {
            return true;
        }

        return false;
    }
	
    static public function is_premium() {
        $flg_premium = self::get_data('flg_premium');
        return empty($flg_premium) ? false : true;
    }

    static function check_auth($auth) {
        $user_auth = self::get_data('auth');

        if ($user_auth & $auth) {
            return true;
        }

        return false;
    }

    static function get_id() {
        return intval(@self::get_data('id'));
    }

    static function reload() {
        $user_model = new User_Model();
        $user = $user_model->get_user_by_id(UserInfo::get_id());

        $rel_user_list = @$_SESSION['pump_'. PC_Config::get('site_id')]['user']['rel_user_list'];
        if (! is_array($rel_user_list)) {
            $rel_user_list = array();
        }

        $_SESSION['pump_'. PC_Config::get('site_id')]['user'] = $user;
        if (@$user) {
            $_SESSION['pump_'. PC_Config::get('site_id')]['user']['rel_user_list'] = $rel_user_list;
        }
        
        self::$_data = null;
    }

    static function get_icon_url($user_id=null, $width=300, $height=300) {
        if ($user_id === null) {
            $image_id = self::get('image_id');
        } else {
            require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';
            $user_model = new User_Model();
            $user = $user_model->get_user_by_id($user_id);
            $image_id = $user['image_id'];
        }
        return PumpImage::get_image_url($image_id, $width, $height, array('crop' => true));
    }

    static function set_session($key, $value) {
        $_SESSION[$key] = $value;
    }

    static function get_session($key) {
        if (empty($_SESSION[$key])) {
            return '';
        }
        return $_SESSION[$key];
    }

    static function unset_session($key) {
        unset($_SESSION[$key]);
    }
}

