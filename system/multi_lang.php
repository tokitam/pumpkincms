<?php

class PC_MultiLang {
    static function check_lang() {

        if (isset($_GET['pump_lang'])) {
            if ($_GET['pump_lang'] == 'japanese') {
                $_SESSION['lang'] = 'japanese';
            } else if ($_GET['pump_lang'] == 'chinese') {
                $_SESSION['lang'] = 'chinese';
            } else {
                $_SESSION['lang'] = 'english';
            }
            return;
        }

        if (isset($_SESSION['lang']) == false) {
            if (preg_match('/ja/', @$_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
                $_SESSION['lang'] = 'japanese';
            } else {
                $_SESSION['lang'] = 'english';
            }
        }
    }
}
