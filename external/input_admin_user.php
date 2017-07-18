<?php

define('PUMPCMS_ROOT_PATH', dirname(pathinfo(__FILE__, PATHINFO_DIRNAME)));
define('PUMPCMS_SYSTEM_PATH', PUMPCMS_ROOT_PATH . '/system');
define('PUMPCMS_PUBLIC_PATH', PUMPCMS_ROOT_PATH . '/public');
define('PUMPCMS_APP_PATH', PUMPCMS_ROOT_PATH . '/app');

require_once PUMPCMS_APP_PATH . '/config/config.php';
require_once PUMPCMS_APP_PATH . '/config/default.php';
require_once PUMPCMS_SYSTEM_PATH . '/require_file.php';

$input_admin_user = new InputAdminUser();
$input_admin_user->run();

class InputAdminUser {
    var $id;
    var $mail;
    var $password;

    public function run() {
        $this->print_title();
        $this->load_config();
        $this->input();
        $this->sql();
    }

    public function print_title() {
        echo "\n";
        echo "===================\n";
        echo "Welcome PumpkinCMS!\n";
        echo "===================\n";
        echo "\n";
    }

    public function load_config() {
        $config_php = PUMPCMS_ROOT_PATH . '/app/config/config.php';

        if (is_readable($config_php) == false) {
            echo "config.php file not found!\n";
            echo "file: " . $config_php . "\n";
            exit();
        }

        require_once $config_php;
    }

    public function input() {
        echo "ADMIN MAIL:";
        $this->mail = trim(fgets(STDIN));  
        echo "ADMIN ID:";
        $this->id = trim(fgets(STDIN));  
        echo "ADMIN PASSWORD:";
        $this->password = trim(fgets(STDIN));  
    }

    public function sql() {
        global $pc_config;

        PC_Config::set('db_no', 1);
        $db = PC_DBSet::get();
        $table = $db->prefix('user_user');

        $sql = sprintf("INSERT INTO  `xzqb_user_user` ( " .
            " `id` , `site_id` , `name` , `password` ,`email` , " .
            " `auth` , `type` , `reg_time` ,`reg_user`  " .
            " ) VALUES ( " .
            " NULL ,  '1',  '%s',  '%s',  '%s',  '1',  '0',  '%d',  '1');", 
            $this->id, 
            sha1($this->password), 
            $this->mail, time());

        echo "Excute this SQL to admin user\n";
        echo "-----------------\n";
        echo $sql . "\n";
        echo "-----------------\n";
    }
}
