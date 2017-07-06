<?php

class PumpFormConfig {

    static $_files = array();

    static public function get_config($module, $table) {
        global $pumpform_config;
        self::load_config($module, $table);
        return $pumpform_config[$module][$table];
    }

    static public function load_config($module) {
        global $pumpform_config;

        if (@self::$_files[$module]) {
            return;
        }

        PC_Util::include_language_file($module);

        $module = preg_replace('/[^0-9A-Za-z_]/', '', $module);

        $file = PUMPCMS_APP_PATH . '/module/' . $module . '/form/form_config.php';

        if (is_readable($file) == false) {
            PC_Abort::error('File not found:' . $file, __FILE__, __LINE__);
        }

        require_once $file;

        self::$_files[$module] = 1;

    }
}
