<?php

require_once PUMPCMS_SYSTEM_PATH . '/util.php';

class OAuth_twitter_Model extends PC_Model {

	function __construct() {
		$this->table_name = 'user_twitter';
	}
	
	function register($user_id, $access_token, $access_token_secret, $twitter_id, $screen_name) {
	    
		$db = PC_DBSet::get();
		
	    $sql = 'INSERT INTO ' . $db->prefix($this->table_name);
	    $sql .= ' ( site_id, access_token, access_token_secret, twitter_id, screen_name, ';
	    $sql .= ' reg_time, mod_time, reg_user, mod_user) ';
	    $sql .= ' VALUES ( ';
	    $sql .= intval(SiteInfo::get_site_id()) . ', ';
	    $sql .= $db->escape($access_token) . ', ';
	    $sql .= $db->escape($access_token_secret) . ', ';
	    $sql .= intval($twitter_id) . ', ';
	    $sql .= $db->escape($screen_name) . ', ';
	    $sql .= time();
	    $sql .= ',  0, 0, 0 )';
	    
	    $db->query($sql);
	}
}
