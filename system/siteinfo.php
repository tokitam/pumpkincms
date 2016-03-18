<?php

require_once PUMPCMS_APP_PATH . '/module/page/model/diralias_model.php';

class SiteInfo {
    static private $_data;
    static private $_site_path;
    static private $_site_id;

    static function set_data($data) {
        self::$_data = $data;
        
        $urls = parse_url(PC_Config::get('base_url'));
        if (@$urls['path'] == '') {
            self::$_site_path = '/';
        } else {
            self::$_site_path = @$urls['path'];
            if (preg_match('@\/$@', self::$_site_path) == false) {
                self::$_site_path .= '/';
            }
        }
    }
    
    static function get($key) {
        return @self::$_data[$key];
    }

    static function set($key, $value) {
        self::$_data[$key] = $value;
    }
    
    static function set_site_id($id) {
        return self::$_site_id = intval($id);
    }

    static function get_site_id() {
        return self::$_site_id;
    }

    static function get_path() {
        return self::$_site_path;
    }

    static function dir2module($dir_name) {

        $diralias_model = new Diralias_Model();
	
        if ($dir_name == '/') {
            $dir_name = PC_Config::get('default_module');
        }

        $d = $diralias_model->get_alias($dir_name);
	
    	if (@$d['module']) {
	       return $d['module'];
    	}

        if (is_dir(PUMPCMS_APP_PATH . '/module/' . $dir_name)) {
            return $dir_name;
        }

        return false;
    }
    
    static function get_css_url() {
        if (isset(self::$_data['css_url'])) {
            return self::$_data['css_url'];
        }
        
        return PC_Config::get('base_url');
    }

    static function is_site_close() {
        if (PC_Config::get('all_site_close')) {
            return true;
        }

        if (PC_Config::get('site_close')) {
            return true;
        }

        return false;
    }
}

