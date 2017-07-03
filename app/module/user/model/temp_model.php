<?php

require_once PUMPCMS_SYSTEM_PATH . '/util.php';

class Temp_Model extends PC_Model {

    function __construct() {
        $this->table_name = 'user_temp';
    }
    
    function register($name, $mail, $password, $code, $type) {
        
        $db = PC_DBSet::get();
        
        $sql = 'INSERT INTO ' . $db->prefix($this->table_name);
        $sql .= ' ( site_id, name, email, password, type, flg_processed, code, reg_time, mod_time, reg_user, mod_user) ';
        $sql .= ' VALUES ( ';
        $sql .= intval(SiteInfo::get_site_id()) . ', ';
        $sql .= $db->escape($name) . ", ";
        $sql .= $db->escape($mail) . ", ";
        $sql .= $db->escape(PC_Util::password_hash($password)) . ", ";
        $sql .= "'" . intval($type) . "', ";
        $sql .= ' 0, ';
        $sql .= $db->escape($code) . ", ";
        $sql .= time();
        $sql .= ',  0, 0, 0 )';
        
        $db->query($sql);

        if ($db->get_driver() == PC_Db_pdo::PGSQL) {
            PC_Debug::log(' seq:' . $db->prefix($this->table_name) . '_id_seq', __FILE__, __LINE__);
            $insert_id = $db->insert_id($db->prefix($this->table_name) . '_id_seq');
        } else {
            $insert_id = $db->insert_id();
        }

        return $insert_id;
    }

    function get_user_data($id_str) {
    
        $str = explode('_', $id_str);
    
        $id = $str[0];
        $code = $str[1];

        if (@$id=='' || @$code== '') {
            return false;
        }
        if (is_numeric($id) == false) {
            return false;
        }

        $db = PC_DBSet::get();
    
            $t = time() - USER_MODEL::TEMP_ENABLE_TIME;

        $sql = 'SELECT * FROM ' . $db->prefix($this->table_name);
        $sql .= ' WHERE id = ' . intval($id) . ' AND ';
        $sql .= ' site_id = ' . intval(SiteInfo::get_site_id()) . ' AND ';
        $sql .= " code = " . $db->escape($code) . " AND ";
            $sql .= ' reg_time > ' . intval($t);

        $row = $db->fetch_row($sql);
    
        return $row;
    }
    
    function update_flg_process($id) {
        
        $db = PC_DBSet::get();
        
        $sql = 'UPDATE  ' . $db->prefix($this->table_name);
        $sql .= ' SET flg_processed = 1 ';
        $sql .= ' WHERE id = ' . intval($id);
        
        $db->query($sql);
    }

}

