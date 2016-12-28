<?php

class PC_Config {
	public static function load_config() {
		
		$ormap = PumpORMAP_Util::get('admin', 'config');
		$list = $ormap->get_list();
		foreach ($list as $key => $value) {
			self::set($value['name'], $value['value']);
		}
	}

	public static function get($key1, $key2=null) {
		global $pc_config;

		if ($key2 != null) {
			return @$pc_config[$key1][$key2];
		}
	    
		if (! empty($pc_config[$key1])) {
		    return $pc_config[$key1];
		}
		
		if (SiteInfo::get($key1) != '') {
		    return SiteInfo::get($key1);
		}

		return @$pc_config[$key1];
	}
    
	public static function set($key, $value) {
		global $pc_config;

		$pc_config[$key] = $value;
		SiteInfo::set($key, $value);
	}
    
    public static function url() {
		global $pc_config;
	
		if (SiteInfo::get('base_url')) {
			return SiteInfo::get('base_url');
		}

		return $pc_config['base_url'];
    }
	
    public static function css_url() {
		return self::get('css_url');
    }
}
