<?php

class PC_Hook {
    static function hook($hook_point) {
        if (!preg_match('/^[_0-9A-Za-z]+$/', $hook_point)) {
            return '';
        }

        if (empty($hook_point)) {
            return '';
        }

        $hook_list = PC_Config::get('hook');

        if (empty($hook_list) || !is_array($hook_list)) {
            return '';
        }

        foreach ($hook_list as $module) {
            if (!preg_match('/^[_0-9A-Za-z]+$/', $hook_point)) {  
                continue;
            }

            $file = PUMPCMS_APP_PATH . '/module/' . $module . '/hook/hook_' . $hook_point . '.php';
            include $file;
        }
    }
}
