<?php

class PC_Notification {

    static public function set($message) {
		if (empty($_SESSION['pump_'. PC_Config::get('site_id')]['notification'])) {
			$_SESSION['pump_'. PC_Config::get('site_id')]['notification'] = $message;
		}
    }

    static public function get() {
        return $_SESSION['pump_'. PC_Config::get('site_id')]['notification'];
    }

    static public function exists() {
        if (@$_SESSION['pump_'. PC_Config::get('site_id')]['notification']) {
            return true;
        }

        return false;
    }

    static public function clear() {
        unset($_SESSION['pump_'. PC_Config::get('site_id')]['notification']);
    }
}
