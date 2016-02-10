<?php

require_once PUMPCMS_SYSTEM_PATH . '/util.php';
require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';

class OAuth_twitter_Model extends PC_Model {

	function __construct() {
		$this->table_name = 'user_twitter';
	}
	
	function register($user_id, $access_token, $access_token_secret, $twitter_id, $screen_name) {
	    
		$db = PC_DBSet::get();
		
	    $sql = 'INSERT INTO ' . $db->prefix($this->table_name);
	    $sql .= ' ( site_id, user_id, access_token, access_token_secret, twitter_id, screen_name, ';
	    $sql .= ' reg_time, mod_time, reg_user, mod_user) ';
	    $sql .= ' VALUES ( ';
	    $sql .= intval(SiteInfo::get_site_id()) . ', ';
	    $sql .= intval($user_id) . ', ';
	    $sql .= $db->escape($access_token) . ', ';
	    $sql .= $db->escape($access_token_secret) . ', ';
	    $sql .= intval($twitter_id) . ', ';
	    $sql .= $db->escape($screen_name) . ', ';
	    $sql .= time();
	    $sql .= ',  0, 0, 0 )';
	    
	    $db->query($sql);
	}

	function get_user($twitter_id) {
		$db = PC_DBSet::get();

		$sql = ' SELECT * FROM ' . $db->prefix($this->table_name);
		$sql .= sprintf(' WHERE site_id = %d AND twitter_id = %d ', SiteInfo::get_site_id(), $twitter_id);
		$sql .= ' ORDER BY id DESC ';
		$sql .= ' LIMIT 1 OFFSET 0 ';

		return $db->fetch_row($sql);
	}

	function login($twitter_user) {
		if (! empty($twitter_user['user_id'])) {
			$user_id = $twitter_user['user_id'];
			$user_model = new user_model();
			$user = $user_model->get_user_by_id($user_id);
			$user_model->update_last_login_time($user_id);
			$_SESSION['pump_'. PC_Config::get('site_id')]['user'] = $user;
			PC_Notification::set(_MD_USER_LOGINED);
			ActionLog::log(ActionLog::LOGIN);
			PC_Util::redirect_top();
		}
	}
}
