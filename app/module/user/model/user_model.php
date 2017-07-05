<?php

require_once PUMPCMS_SYSTEM_PATH . '/util.php';

class User_Model extends PC_Model {

    const USER_REL_MAX = 20;
    const TEMP_ENABLE_TIME = 3600; // 60 * 60 * 10
    
    var $_user_data;
    var $_check_password = true;
    var $_check_email = true;

    function __construct() {
        $this->table_name = 'user_user';
    }
    
    function register($user) {

        if (! empty($user['display_name'])) {
            $display_name = $user['display_name'];
        } else {
            $display_name = $user['name'];
        }

        $db = PC_DBSet::get();

        $sql = 'INSERT INTO ' . $db->prefix($this->table_name);
        $sql .= " (site_id, name, display_name, password, email, type, reg_time";
        if (isset($user['image_id']) && is_numeric($user['image_id'])) {
            $sql .= ', image_id ';
        }
        $sql .= ' ) VALUES ';
        $sql .= " ( ";
        $sql .= intval(SiteInfo::get_site_id()) . ', ';
        $sql .= " " . $db->escape($user['name']) . ", ";
        $sql .= " " . $db->escape($display_name) . ", ";
        $sql .= " " . $db->escape(@$user['password']). ", ";
        $sql .= " " . $db->escape(@$user['email']) . ", ";
        $sql .= " '" . intval(@$user['type']) . "', ";
        $sql .= " " . time(). " ";
        if (isset($user['image_id']) && is_numeric($user['image_id'])) {
            $sql .= ', ' . intval($user['image_id']);
        }
        $sql .= " ) ";

        return $db->query($sql);
        
    }
    
    function login() {
    
        $error = $this->login_validate();
        
        if (count($error) == 0) {
            $this->update_last_login_time($this->_user_data['id']);
            $_SESSION['pump_'. PC_Config::get('site_id')]['user'] = $this->_user_data;
            PC_Notification::set(_MD_USER_LOGINED);
            ActionLog::log(ActionLog::LOGIN);

            $this->load_rel_user($this->_user_data['id']);
            
            if (empty($_SESSION['from_url'])) {
                PC_Util::redirect_top();
            } else {
                PC_Util::redirect_top();
                //PC_Util::redirect(PC_Config::url() . $_SESSION['from_url']);
            }
        } else {
            return $error;
        }
    }
    
    function logout() {
        ActionLog::log(ActionLog::LOGOUT);
        unset($_SESSION['pump_'. PC_Config::get('site_id')]);
        PC_Notification::set(_MD_USER_LOGOUT);
        PC_Util::redirect_top();
    }

    function load_rel_user($user_id) {
        $user_rel_ormap = PumpORMAP_Util::get('user', 'user_rel');
        $list = $user_rel_ormap->get_list('user_id1 = ' . intval($user_id) . ' OR user_id2 = ' . intval($user_id), 0, self::USER_REL_MAX);

        $rel_user_list = array();
        foreach ($list as $item) {
            if ($item['user_id1'] == $user_id) {
                $tmp_id = $item['user_id2'];
            } else {
                $tmp_id = $item['user_id1'];
            }

            $tmp = $this->get_user_by_id($tmp_id);
            if (empty($tmp)) {
            continue;
            }
            array_push($rel_user_list, $tmp);
        }

        UserInfo::set('rel_user_list', $rel_user_list);

        return $rel_user_list;
    }

    function switch_user($to_user_id) {
        if (! UserInfo::is_logined()) {
            exit();
        }

        $user_rel_ormap = PumpORMAP_Util::get('user', 'user_rel');
        if (UserInfo::get_id() < $to_user_id) {
            $user_id1 = UserInfo::get_id();
            $user_id2 = $to_user_id;
        } else {
            $user_id1 = $to_user_id;
            $user_id2 = UserInfo::get_id();
        }
        $list = $user_rel_ormap->get_list('user_id1 = ' . intval($user_id1) . ' OR user_id2 = ' . intval($user_id2), 0, 1);

        if (empty($list)) {
            exit();
        }

        $user_id = $to_user_id;

        $user = $this->get_user_by_id($user_id);

        $this->update_last_login_time($user['id']);
        $_SESSION['pump_'. PC_Config::get('site_id')]['user'] = $user;
        PC_Notification::set(_MD_USER_SWITCH_USER);
        ActionLog::log(ActionLog::LOGIN);

        $this->load_rel_user($user['id']);
        
        if (empty($_SESSION['last_url'])) {
            PC_Util::redirect_top();
        } else if (PC_Util::is_url($_SESSION['last_url'])) {
            PC_Util::redirect($_SESSION['last_url']);
        } else {
            PC_Util::redirect_top();
        }
    }

    function add_user_rel($to_user_id) {
        if (! UserInfo::is_logined()) {
            exit();
        }

        $user_rel_ormap = PumpORMAP_Util::get('user', 'user_rel');

        $user_id = UserInfo::get_id();
        $tmp_list = $user_rel_ormap->get_list('user_id1 = ' . intval($user_id) . ' OR user_id2 = ' . intval($user_id));

        $now_rel_list = array();

        foreach ($tmp_list as $item) {
            if ($item['user_id1'] == UserInfo::get_id()) {
                array_push($now_rel_list, intval($item['user_id2']));
            } else {
                array_push($now_rel_list, intval($item['user_id1']));
            }
        }

        $ids = implode(',', $now_rel_list);

        $tmp_list = $user_rel_ormap->get_list('user_id1 IN (' . $ids . ') OR user_id2 IN (' . $ids . ' ) ');
        $tmp_id_list = array();
        foreach ($tmp_list as $item) {
            array_push($tmp_id_list, $item['user_id1']);
            array_push($tmp_id_list, $item['user_id2']);
        }

        array_push($tmp_id_list, UserInfo::get_id());
        $now_rel_list2 = $now_rel_list = $tmp_id_list;
PC_Debug::log('now_rel_list:' . print_r($now_rel_list, true), __FILE__, __LINE__);
        foreach ($now_rel_list as $i) {
            foreach ($now_rel_list2 as $j) {
                if ($i == $j) {

PC_Debug::log('id hit', __FILE__, __LINE__);
                    continue;
                }

                if ($i < $j) {
                    $user_id1 = $i;
                    $user_id2 = $j;
                } else {
                    $user_id1 = $j;
                    $user_id2 = $i;
                }

                $tmp_list2 = $user_rel_ormap->get_list('user_id1 = ' . intval($user_id1) . ' AND user_id2 = ' . intval($user_id2));

                if (! empty($tmp_list2)) {
                    continue;
                }

                $user_rel_ormap->insert(array('user_id1' => $user_id1, 'user_id2' => $user_id2));
            }
        }
    }

    function delete_user_rel($self_user_id, $delete_user_id) {
        $list = $this->get_user_rel_list($self_user_id);
        array_push($list, $delete_user_id);

        if (count($list) == 1) {
            $ids = intval($list[0]);
        } else {
            $ids = implode(',', $list);
        }

        $user_rel_ormap = PumpORMAP_Util::get('user', 'user_rel');
        $tmp_list = $user_rel_ormap->get_list('user_id1 IN (' . $ids . ') OR user_id2 IN (' . $ids . ' ) ');

        foreach ($tmp_list as $item) {
            if ($item['user_id1'] == $delete_user_id || $item['user_id2'] == $delete_user_id) {
                $user_rel_ormap->delete($item['id']);
            }
        }
    }

    function get_user_rel_list($user_id) {
        $user_rel_ormap = PumpORMAP_Util::get('user', 'user_rel');
        $tmp_list = $user_rel_ormap->get_list('user_id1 = ' . intval($user_id) . ' OR user_id2 = ' . intval($user_id));

        $list = array();
        foreach ($tmp_list as $item) {
            if ($item['user_id1'] == $user_id) {
                array_push($list, $item['user_id2']);
            } else {
                array_push($list, $item['user_id1']);
            }
        }

        return $list;
    }

    function admin_mode($flg) {
        if ($flg) {
            $_SESSION['pump_'. PC_Config::get('site_id')]['user']['admin_mode'] = 1;
        } else {
            unset($_SESSION['pump_'. PC_Config::get('site_id')]['user']['admin_mode']);
        }
    }
    
    function login_validate() {
        $error = array();

        if (!isset($_POST['email'])) {
            //array_unshift($error, _MD_USER_INPUT_EMAIL . '(1)');
            $error['email'] = _MD_USER_INPUT_EMAIL . '(1)';
        } else {
            if (strlen($_POST['email']) < 3 || 127 < strlen($_POST['email'])) {
                //array_unshift($error, _MD_USER_ERROR_LENGTH . '(2)');
                $error['email'] = _MD_USER_ERROR_LENGTH . '(2)';
            }
            if (!preg_match('/[0-9A-Za-z]+/', $_POST['email'])) {
                //array_unshift($error, _MD_USER_ERROR_LENGTH . '(3)');
                $error['email'] = _MD_USER_ERROR_LENGTH . '(3)';
            }
        }
        
        if (!isset($_POST['password'])) {
            //array_unshift($error, _MD_USER_INPUT_PASSWORD . '(4)');
            $error['password'] = _MD_USER_INPUT_PASSWORD . '(4)';
        } else {
            if (strlen($_POST['password']) < 3 || 127 < strlen($_POST['password'])) {
                //array_unshift($error, _MD_USER_ERROR_LENGTH . '(5)');
                $error['password'] = _MD_USER_ERROR_LENGTH . '(5)';
            }
            if (!preg_match('/[0-9A-Za-z]+/', $_POST['password'])) {
                //array_unshift($error, _MD_USER_ERROR_LENGTH . '(6)');
                $error['password'] = _MD_USER_ERROR_LENGTH . '(6)';
            }
        }
        
        if (count($error) == 0) {
            $this->_user_data = $this->select_user();
            
            if (PC_Util::password_verify($_POST['password'], $this->_user_data['password'])) {
            $pass_check = true;
            } else {
            $pass_check = false;
            }
            
            if ($this->_user_data == false || $pass_check == false) {
                //array_unshift($error, _MD_USER_ERROR_NOTFOUND . '(7)');
                $error['email'] = _MD_USER_ERROR_NOTFOUND . '(7)';
            }
        }
        
        return $error;
    }
    
    function register_validate() {
        $error = array();

        if (@$_POST['name'] == '') {
            //array_unshift($error, _MD_USER_INPUT_NAME . '(1)');
            $error['name'] = _MD_USER_INPUT_NAME . '(1)';
        } else {
            if (strlen($_POST['name']) < 4 || 16 < strlen($_POST['name'])) {
                //array_unshift($error, _MD_USER_ERROR_LENGTH . '(2)');
                $error['name'] = _MD_USER_ERROR_LENGTH . '(2)';
            }
            if (!preg_match('/^[0-9A-Za-z]+$/', $_POST['name'])) {
                //array_unshift($error, _MD_USER_ERROR_FORMAT . '(3)');
                $error['name'] = _MD_USER_ERROR_FORMAT . '(3)';
            }
        }
        
        if ($this->_check_email) {
        if (@$_POST['email'] == '') {
            //array_unshift($error, _MD_USER_INPUT_EMAIL . '(4)');
            $error['email'] = _MD_USER_INPUT_EMAIL . '(4)';
        } else {
            if (strlen($_POST['email']) < 3 || 32 < strlen($_POST['email'])) {
                //array_unshift($error, _MD_USER_ERROR_LENGTH . '(5)');
                $error['email'] = _MD_USER_ERROR_LENGTH . '(5)';
            }
                if (!PC_Util::is_email($_POST['email'])) {
                //array_unshift($error, _MD_USER_ERROR_FORMAT2 . '(6)');
                $error['email'] = _MD_USER_ERROR_FORMAT2 . '(6)';
            }
        }
            
            if ($this->exists_name(@$_POST['name'], @$_POST['email'])) {
                //array_unshift($error, _MD_USER_ERROR_USER_EXISTS . '(10)');
                $error['name'] = _MD_USER_ERROR_USER_EXISTS . '(10)';
            }
        
            }
        
        if ($this->_check_password) {
            if (@$_POST['password'] == '') {
                //array_unshift($error, _MD_USER_INPUT_PASSWORD . '(7)');
                $error['password'] = _MD_USER_INPUT_PASSWORD . '(7)';
            } else {
                if (strlen($_POST['password']) < 3 || 16 < strlen($_POST['password'])) {
                    //array_unshift($error, _MD_USER_ERROR_LENGTH . '(8)');
                    $error['password'] = _MD_USER_ERROR_LENGTH . '(8)';
                }
            }
        }

            if ($this->exists_name(@$_POST['name'])) {
                $error['name'] = _MD_USER_ERROR_USER_EXISTS . '(10)';
        }
        
        return $error;
    }
    
    function reset_validate() {
        $error = array();
        
        if (@$_POST['new_password'] == '') {
            array_unshift($error, _MD_USER_INPUT_PASSWORD . '(7)');
        } else {
            if (strlen($_POST['new_password']) < 3 || 16 < strlen($_POST['new_password'])) {
                array_unshift($error, _MD_USER_ERROR_LENGTH . '(8)');
            }
        }
        
        if (@$_POST['new_password2'] == '') {
            array_unshift($error, _MD_USER_INPUT_PASSWORD . '(7)');
        } else {
            if (strlen($_POST['new_password2']) < 3 || 16 < strlen($_POST['new_password2'])) {
                array_unshift($error, _MD_USER_ERROR_LENGTH . '(8)');
            }
        }
        
            if ($_POST['new_password'] != $_POST['new_password2']) {
            array_unshift($error, _MD_USER_PASSWORD_NOT_ACCORD . '(9)');
        }
        
        return $error;
    }
    
    function select_user() {
        
        $db = PC_DBSet::get();
        
        $sql = 'SELECT * FROM ' . $db->prefix($this->table_name);
        $sql .= " WHERE ";
            $sql .= 'site_id = ' . intval(SiteInfo::get_site_id()) . ' AND ';
        $sql .= " email = " . $db->escape($_POST['email']);

        return $db->fetch_row($sql);
    }
    
    function exists_user($name, $email) {
            $table = 'user_temp';
        
        $db = PC_DBSet::get();
        
            $t = time() - self::TEMP_ENABLE_TIME;
        
        $sql = 'SELECT * FROM ' . $db->prefix($table);
        $sql .= " WHERE ";
        $sql .= ' site_id = ' . intval(SiteInfo::get_site_id()) . ' AND ';
            $sql .= ' reg_time > ' . intval($t) . ' AND ( ';
        $sql .= " name = " . $db->escape($name) . " OR ";
        $sql .= " email = " . $db->escape($email) . " ";
            $sql .= ' ) ';

            $list = $db->fetch_assoc($sql);

            if (0 < count($list)) {
            return true;
        } else {
            return false;
        }
    }
    
    function exists_name($name) {
            $table = 'user_temp';
        
        $db = PC_DBSet::get();
        
            $t = time() - self::TEMP_ENABLE_TIME;
        
        $sql = 'SELECT * FROM ' . $db->prefix($table);
        $sql .= " WHERE ";
        $sql .= ' site_id = ' . intval(SiteInfo::get_site_id()) . ' AND ';
            $sql .= ' reg_time > ' . intval($t) . ' AND ( ';
        $sql .= " name = " . $db->escape($name);
            $sql .= ' ) ';

            $list = $db->fetch_assoc($sql);

            if (0 < count($list)) {
            return true;
        } else {
            return false;
        }
    }
    
    function exists_email($email) {
            $table = 'user';
        
        $db = PC_DBSet::get();
        
        $sql = 'SELECT * FROM ' . $db->prefix($table);
        $sql .= " WHERE ";
        $sql .= ' site_id = ' . intval(SiteInfo::get_site_id()) . ' AND ';
        $sql .= " email = " . $db->escape($email) . " ";

            $row = $db->fetch_row($sql);
        
            if ($row == false) {
            return false;
        } else {
            return true;
        }
    }
    
    function get_user_by_id($id) {
        
        $db = PC_DBSet::get();
        
        $sql = 'SELECT * FROM ' . $db->prefix($this->table_name);
        $sql .= " WHERE ";
        $sql .= " id = '" . intval($id) . "' ";

            return $db->fetch_row($sql);
    }
    
    function get_user_by_name($name) {
        
        $db = PC_DBSet::get();
        
        $sql = 'SELECT * FROM ' . $db->prefix($this->table_name);
        $sql .= " WHERE ";
        $sql .= ' site_id = ' . intval(SiteInfo::get_site_id()) . ' AND ';
        $sql .= " name = " . $db->escape($name) . " ";

            return $db->fetch_row($sql);
    }
    
    function get_user_by_email($email) {
        
        $db = PC_DBSet::get();
        
        $sql = 'SELECT * FROM ' . $db->prefix($this->table_name);
        $sql .= " WHERE ";
        $sql .= ' site_id = ' . intval(SiteInfo::get_site_id()) . ' AND ';
        $sql .= " email = " . $db->escape($email) . " ";

            return $db->fetch_row($sql);
    }
    
    function get_remindpass_user($code) {
            $table = 'user_remindpass';
        
            $tmp = explode('_', $code);
            $id = intval($tmp[0]);
            $code = $tmp[1];
        
        $db = PC_DBSet::get();
        
        $sql = 'SELECT * FROM ' . $db->prefix($table);
        $sql .= " WHERE ";
        $sql .= " id = '" . intval($id) . "' AND ";
            $sql .= " code = " . $db->escape($code) . " ";

            return $db->fetch_row($sql);
    }
    
    function update_password($id, $password) {
        $db = PC_DBSet::get();
        
        $sql = 'UPDATE ' . $db->prefix($this->table_name);
        $sql .= " SET ";
            $sql .= " password= " . $db->escape(PC_Util::password_hash($password)) . " ";
            $sql .= " WHERE id = '" . intval($id) . "' ";

            return $db->query($sql);
    }
    
    function update_flg_tel_auth($id, $flg_tel_auth, $tel_country='', $tel_no='', $vote_disable_time=0) {
        $db = PC_DBSet::get();
        
        $sql = 'UPDATE ' . $db->prefix($this->table_name);
        $sql .= " SET ";
        $sql .= " flg_tel_auth = " . intval($flg_tel_auth) . " ";
            $sql .= ", tel_country = ". $db->escape($tel_country). " ";
            $sql .= ", tel_no = ". $db->escape($tel_no). " ";
            $sql .= ", vote_disable_time = ". intval($vote_disable_time). " ";

            $sql .= " WHERE id = '" . intval($id) . "' ";

            return $db->query($sql);
    }

    function update_last_login_time($id) {
        $db = PC_DBSet::get();
        
        $sql = 'UPDATE ' . $db->prefix($this->table_name);
        $sql .= " SET ";
        $sql .= " last_login_time = " . time();
        $sql .= " WHERE id = '" . intval($id) . "' ";

        return $db->query($sql);
    }

    function update_image_id($user_id, $image_id) {
        $db = PC_DBSet::get();
        
        $sql = 'UPDATE ' . $db->prefix($this->table_name);
        $sql .= ' SET ';
        $sql .= ' image_id = ' . intval($image_id);
            $sql .= ' WHERE ';
            $sql .= ' site_id = ' . intval(SiteInfo::get_site_id()) . ' AND ';
            $sql .= ' id = ' . intval($user_id);

        return $db->query($sql);
    }
}

