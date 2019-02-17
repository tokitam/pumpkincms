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

        $extra_file = '';
        if ($module == 'user' && PC_Config::get('extra_user_profile')) {
            $c = PC_Config::get('extra_user_profile');
            $module = $c['module'];
            $extra_file = PUMPCMS_APP_PATH . '/module/' . $module . '/form/extra_form_config_user.php';
            if (is_readable($extra_file)) {
                require_once $extra_file;
            }    
        }

        $file = PUMPCMS_APP_PATH . '/module/' . $module . '/form/form_config.php';

        if (is_readable($extra_file) == false && is_readable($file) == false) {
            PC_Abort::error('File not found:' . $file, __FILE__, __LINE__);
        }

        self::$_files[$module] = 1;

        require_once $file;
    }
}
