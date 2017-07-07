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

        if (empty($GLOBALS['pumpform_config'][$module][$table])) {
            echo 'Formdata not found: module:' . $module . ', table:' . $table;
            exit();
        }

        self::$_ormap[$module][$table] = new PumpORMAP($GLOBALS['pumpform_config'][$module][$table]);

        return self::$_ormap[$module][$table];
    }
}
