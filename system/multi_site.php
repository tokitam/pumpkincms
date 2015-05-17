<?php

require_once PUMPCMS_SYSTEM_PATH . '/siteinfo.php';

class PC_MultiSite {
    static function check_site() {

        $site_list = PC_Config::get('site_list');

        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
             $_SERVER['HTTP_HOST'] = $_SERVER['HTTP_X_FORWARDED_HOST'];
        }
	
	$host = strtolower(@$_SERVER['HTTP_HOST']);
	
        foreach ($site_list as $site => $site_data) {
            $site_id = $site_data['site_id'];
	    
            $urls = parse_url('http://' . $site);
	    
            $path = isset($urls['path']) ? $urls['path'] : '';
            $path = substr($path, 0, strlen($path) - 1);
	    
            if (@$host == $urls['host'] &&
                preg_match('@' . $path . '@', $_SERVER['REQUEST_URI'])) {
		    
                PC_Config::set('site_id', $site_id);
                PC_Config::set('base_url', 'http://' . $site);
                self::set_site_info($site_data);
                return;
            }
        }

        $site_list = PC_Config::get('site_list');
        $site_config = PC_Config::get('site_config');
        $catchall = PC_Config::get('site_config_catchall');
        $site_data = $site_config[$catchall];
        $site_data['site_id'] = $catchall;
        self::set_site_info($site_data);
        PC_Config::set('site_id', $catchall);

    }
    
    static function set_site_info($data) {
        global $site_info;

        $site_id = $data['site_id'];
	
        $site_config = PC_Config::get('site_config');
        $info = $site_config[$site_id];
        PC_Config::set('layout', @$info['default_layout']);
        PC_Config::set('site_title', @$info['site_title']);
        if (@$data['css_url']) {
            $info['css_url'] = $data['css_url'];
        }

        SiteInfo::set_data($info);
        SiteInfo::set_site_id($site_id);
	    
    }
}

