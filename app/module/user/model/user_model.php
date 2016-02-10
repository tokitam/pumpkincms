<?php

require_once PUMPCMS_SYSTEM_PATH . '/util.php';

class User_Model extends PC_Model {
    
    const TEMP_ENABLE_TIME = 3600; // 60 * 60 * 10
    
    var $_user_data;

	function __construct() {
		$this->table_name = 'user_user';
	}
	
	function register($user) {

		$db = PC_DBSet::get();

		$sql = 'INSERT INTO ' . $db->prefix($this->table_name);
		$sql .= " (site_id, name, password, email, type, reg_time ) VALUES ";
	        $sql .= " ( ";
	    $sql .= intval(SiteInfo::get_site_id()) . ', ';
		$sql .= " " . $db->escape($user['name']) . ", ";
		$sql .= " " . $db->escape($user['password']). ", ";
		$sql .= " " . $db->escape($user['email']) . ", ";
		$sql .= " '" . intval($user['type']) . "', ";
		$sql .= " " . time(). " ";
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
			PC_Util::redirect_top();
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
		
		if (@$_POST['password'] == '') {
			//array_unshift($error, _MD_USER_INPUT_PASSWORD . '(7)');
			$error['password'] = _MD_USER_INPUT_PASSWORD . '(7)';
		} else {
			if (strlen($_POST['password']) < 3 || 16 < strlen($_POST['password'])) {
				//array_unshift($error, _MD_USER_ERROR_LENGTH . '(8)');
				$error['password'] = _MD_USER_ERROR_LENGTH . '(8)';
			}
		}

	        if ($this->exists_user(@$_POST['name'], @$_POST['email'])) {
		        //array_unshift($error, _MD_USER_ERROR_USER_EXISTS . '(10)');
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
    
	function exists_email($email) {
	        $table = 'user';
	    
		$db = PC_DBSet::get();
		
		$sql = 'SELECT * FROM ' . $db->prefix($table);
		$sql .= " WHERE ";
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
    
	function get_user_by_email($email) {
	    
		$db = PC_DBSet::get();
		
		$sql = 'SELECT * FROM ' . $db->prefix($this->table_name);
		$sql .= " WHERE ";
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
}

