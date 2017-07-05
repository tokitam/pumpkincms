<?php

class Diralias_Model extends PC_Model {
    var $_table_name;
    
    function __construct() {
        $this->_table_name = 'page_diralias';
    }
    
    function get_alias($dir_name='') {
        $db = PC_DBSet::get();
        
        $sql = 'SELECT * FROM ' . $db->prefix($this->_table_name);
        $sql .= " WHERE ";
        $sql .= ' site_id = ' . intval(SiteInfo::get_site_id()) . ' AND ';
        $sql .= " dir = " . $db->escape($dir_name) . " ";
        $sql .= ' LIMIT 1 ';

        return $db->fetch_row($sql);
    }
}

