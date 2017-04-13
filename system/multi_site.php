<?php

require_once PUMPCMS_SYSTEM_PATH . '/siteinfo.php';

class PC_MultiSite {
    static function load_site_config() {
        global $pc_config;
        PC_Config::set('db_no', 1);
        PC_Config::set('site_id', 1);

        $site_list_ormap = PumpORMAP_Util::get('admin', 'site_list');
        $site_list = $site_list_ormap->get_list('', 0, 1000);
        
        $all_site_list = PC_Config::get('site_list');
        foreach ($site_list as $list) {
            $site_id = $list['m_site_id'];
            $all_site_list[$list['domain_dir']] = array('site_id' => $site_id);
        }
        PC_Config::set('site_list', $all_site_list);
        
        $site_config_ormap = PumpORMAP_Util::get('admin', 'site_config');
        $site_config = $site_config_ormap->get_list('', 0, 1000);
        
        $all_site_config = PC_Config::get('site_config');
        foreach ($site_config as $config) {
            $config['site_id'] = $config['id'];
            $all_site_config[$config['id']] = $config;
        }
        PC_Config::set('site_config', $all_site_config);
    }
    
    static function check_site() {
        if (PC_Config::get('multi_site_db_setting')) {
            self::load_site_config();
        }
        
        $site_list = PC_Config::get('site_list');

        if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
             $_SERVER['HTTP_HOST'] = @$_SERVER['HTTP_X_FORWARDED_HOST'];
        }
        
        $host = strtolower(@$_SERVER['HTTP_HOST']);
        PC_Config::set('REQUEST_URI', @$_SERVER['REQUEST_URI']);

        foreach ($site_list as $site => $site_data) {
            $site_id = $site_data['site_id'];
            
            $urls = parse_url('http://' . $site);
            
            $path = isset($urls['path']) ? $urls['path'] : '';
            $path = substr($path, 0, strlen($path) - 1);
            
            if (@$host == $urls['host'] &&
                preg_match('@' . $path . '@', @$_SERVER['REQUEST_URI'])) {
                    
                PC_Config::set('site_id', $site_id);
				if (isset($site_data['base_url'])) {
					PC_Config::set('base_url', $site_data['base_url']);
                } else {
					PC_Config::set('base_url', 'http://' . $site);
				}
                self::set_site_info($site_data);
                return;
            }
        }

        $site_list = PC_Config::get('site_list');
        $site_config = PC_Config::get('site_config');
        $catchall = PC_Config::get('site_config_catchall');
        $site_data = $site_config[$catchall];
        $site_data['site_id'] = $catchall;
        PC_Config::set('site_id', $catchall);
        $service_url = PC_Util::get_service_base_path();
        PC_Config::set('base_url', 'http://' . @$_SERVER['SERVER_NAME'] . $service_url);
        self::set_site_info($site_data);
    }
    
    static function set_site_info($data) {
        global $site_info;

        $site_id = $data['site_id'];
        
        $site_config = PC_Config::get('site_config');
        $info = $site_config[$site_id];
        PC_Config::set('theme', @$info['theme']);
        PC_Config::set('site_title', @$info['site_title']);
        if (@$data['css_url']) {
            $info['css_url'] = $data['css_url'];
        }

        SiteInfo::set_data($info);
        SiteInfo::set_site_id($site_id);
    }

    static function console_setup() {
        global $argv;
        global $_SERVER;
        global $_GET;

        if (isset($_REQUEST['HTTP_HOST'])) {
            // browser access
            return;
        }

        if (empty($_SERVER['REQUEST_URI'])) {
            $_SERVER['REQUEST_URI'] = '/';
        }

        if (empty($argv[1])) {
            return;
        }

        $url = parse_url($argv[1]);
        $_SERVER['REQUEST_URI'] = @$url['path'];

        if (isset($url['query'])) {
            parse_str($url['query'], $query);

            foreach ($query as $key => $val) {
                $_GET[$key] = $val;
            }
        }

    }
}

