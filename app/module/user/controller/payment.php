<?php

class user_payment extends PC_Controller {
    public function __construct() {
    }

    public function index() {
        if (UserInfo::is_logined() == false) {
            //PC_Util::redirect_top();
        }
		
		printf(" <a href='%s'>set</a><br /> ", PC_Config::url() . '/user/payment/?type=monthly_paypal&action=set');
		printf(" <a href='%s'>unsubscribe</a><br /> ", PC_Config::url() . '/user/payment/?type=monthly_paypal&action=unsubscribe');
		printf(" <a href='%s'>detail</a><br /> ", PC_Config::url() . '/user/payment/?type=monthly_paypal&action=detail');
		
		if (isset($_GET['type']) && preg_match('/^[_0-9A-Za-z]+$/', $_GET['type'])) {
			$plugin = $_GET['type'];
			require_once PUMPCMS_APP_PATH . '/module/user/plugin/' . $plugin . '/' . $plugin . '.php';
			$plugin_obj = new $plugin();
			if (isset($_GET['action']) && preg_match('/^[_0-9A-Za-z]+$/', $_GET['action'])) {
				$action = $_GET['action'];
				$plugin_obj->$action();
			}
		}
	}
}
