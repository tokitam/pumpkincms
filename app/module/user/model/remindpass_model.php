<?php

require_once PUMPCMS_SYSTEM_PATH . '/util.php';

class Remindpass_Model extends PC_Model {

	function __construct() {
		$this->table_name = 'user_remindpass';
	}
	
	function register($user_id, $email, $code) {
		$db = PC_DBSet::get();
		
	    $sql = 'INSERT INTO ' . $db->prefix($this->table_name);
	    $sql .= ' (site_id, user_id, code, reg_time) ';
	    $sql .= ' VALUES ( ';
	    $sql .= intval(SiteInfo::get_site_id()) . ', ';
	    $sql .= "'" . intval($user_id) . "', ";
	    $sql .= " " . $db->escape($code) . ", ";
	    $sql .= time();
	    $sql .= ')';

	    $db->query($sql);
	    return $db->insert_id();
	}

    
}

