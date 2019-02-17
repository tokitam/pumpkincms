<?php

class User_Util {
    static function delete_user($user_id) {
        $dir = PUMPCMS_APP_PATH . '/module/user/plugin/';
        $dh = opendir($dir);
        while (($file = readdir($dh)) !== false) {
            $dir_p = $dir . $file . '/' . $file . '_user.php';
            echo $dir_p . " \n";
            if ($dir_p != '.' && $dir_p != '..' && is_readable($dir_p)) {
                require_once $dir_p;
                $class = $file . '_user';
                $obj = new $class();
                $method = 'delete';
                $obj->$method($user_id);
            }
        }
    }
}
