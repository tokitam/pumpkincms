<?php

class Page_Model extends PC_Model {
    var $_table_name;
    
    function __construct() {
        $this->_table_name = 'page_page';
    }
    
    function get_page($dir_name='') {
        $db = PC_DBSet::get();

        if ($dir_name == '') {
            $dir_name = 'index';
        }
        
        $sql = 'SELECT * FROM ' . $db->prefix($this->_table_name);
        $sql .= " WHERE ";
        $sql .= ' site_id = ' . intval(SiteInfo::get_site_id()) . ' AND ';
        $sql .= " dir_name = " . $db->escape($dir_name) . " ";

        return $db->fetch_row($sql);
    }
}

