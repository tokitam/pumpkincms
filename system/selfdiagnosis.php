<?php


class PumpSelfDiagnosis {
    static public function diagnosis() {
        $message = '';
        if (self::diagnosis_config() == false) {
            //self::start_installer();
            $message .= "APP/config/config.php not readable<br />";
        }
        if (self::diagnosis_default() == false) {
            $message .= "APP/config/default.php not readable<br />";
        }
        if (self::diagnosis_auth_cache() == false) {
            $message .= "APP/cache/ not writable [ # chmod 777 cache ]<br />";
        }
        if (self::diagnosis_auth_upload() == false) {
            $message .= "APP/upload/ not writable [ # chmod 777 upload ]<br />";
        }
        if (self::diagnosis_auth_image() == false) {
            $message .= "PUBLIC/image/ not writable [ # chmod 777 image ]<br />";
        }
        if (self::diagnosis_gd() == false) {
            $message .= 'GD library not found.<br />';
        }

        if ($message != '') {
            echo "Error!!!<br />";
            echo $message;
            die();
        }
    }

    static public function start_installer() {
        require_once PUMPCMS_APP_PATH . '/module/installer/class/installer.php';

        $installer = new Installer();
        $installer->run();
    }

    static public function diagnosis_config() {
        $config_file = PUMPCMS_APP_PATH . '/config/config.php';
        if (is_readable($config_file) == false) {
            return false;
        }

        return true;
    }

    static public function diagnosis_default() {
        $config_file = PUMPCMS_APP_PATH . '/config/default.php';
        if (is_readable($config_file) == false) {
            return false;
        }

        return true;
    }

    static public function diagnosis_auth_cache() {
        $cache_dir = PUMPCMS_APP_PATH . '/cache';
        if (is_writable($cache_dir) == false) {
            return false;
        }

        return true;
    }

    static public function diagnosis_auth_upload() {
        $upload_dir = PUMPCMS_APP_PATH . '/upload';
        if (is_writable($upload_dir) == false) {
            return false;
        }

        return true;
    }
    
    static public function diagnosis_auth_image() {
        $upload_dir = PUMPCMS_PUBLIC_PATH . '/image';
        if (is_writable($upload_dir) == false) {
            return false;
        }

        return true;
    }

    static public function diagnosis_gd() {
        if (function_exists('ImageCreateTrueColor') == false) {
            return false;
        }

        return true;
    }
}


