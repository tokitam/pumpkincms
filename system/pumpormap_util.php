<?php

require_once PUMPCMS_SYSTEM_PATH . '/pumpormap.php';

class PumpORMAP_Util {
	static public $_ormap;
	static $_readed_form_config;

    static function getInstance($module, $table)
    {
        return self::get($module, $table);
    }

	static function get($module, $table)
    {
        if (isset(self::$_ormap) == false) {
            self::$_ormap = array();
        }
        
		if (@self::$_ormap[$module][$table]) {
			return self::$_ormap[$module][$table];
		}

        PC_Util::include_language_file('pumpform');
        PC_Util::include_language_file($module);

		//self::load_form_config($module, $table);
        PumpFormConfig::load_config($module, $table);

    	self::$_ormap[$module][$table] = new PumpORMAP($GLOBALS['pumpform_config'][$module][$table]);

        return self::$_ormap[$module][$table];
    }

/*
    static function load_form_config($module, $table) {
        global $pumpform_config;
	
        if (isset(self::$_readed_form_config) == false) {
            self::$_readed_form_config = array();
        }

		if (@self::$_readed_form_config[$module][$table]) {
		    return;
		}

        $module = preg_replace('/[^0-9A-Za-z_]/', '', $module);
        $table = preg_replace('/[^0-9A-Za-z_]/', '', $table);
        
        $file = PUMPCMS_APP_PATH . '/module/' . $module . '/form/form_config.php';
        
        if (is_readable($file) == false) {
            PC_Abort::error('File not found:' . $file, __FILE__, __LINE__);
        }
        
        require_once $file;
        
        self::$_readed_form_config[$module][$table] = true;
    }
    */
}

