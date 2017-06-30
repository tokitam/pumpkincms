<?php

class PC_DBSet {
    static $_db_list = array();

    public static function get() {
        global $pc_config;

        $no = PC_Config::get('db_no');

        if (isset($_db_list[$no])) {
            return self::$_db_list[$no];
        }

        $db_type = $pc_config['database'][$no]['db_type'];

        if ($db_type == 'pdo') {
            require_once PUMPCMS_SYSTEM_PATH . '/db_pdo.php';

            self::$_db_list[$no] = new PC_Db_pdo();
            self::$_db_list[$no]->connect();
        } else if ($db_type == 'mysql') {
            require_once PUMPCMS_SYSTEM_PATH . '/db_mysql.php';

            self::$_db_list[$no] = new PC_Db_mysql();
            self::$_db_list[$no]->connect();
        } else {
            require_once PUMPCMS_SYSTEM_PATH . '/db_sqlite3.php';

            self::$_db_list[$no] = new PC_Db_sqlite3();
            self::$_db_list[$no]->connect();
        }


        return self::$_db_list[$no];
    }

    public static function get_db_type() {
        global $pc_config;

        $no = PC_Config::get('db_no');

        $db_type = $pc_config['database'][$no]['db_type'];

        return $db_type;
    }
}

