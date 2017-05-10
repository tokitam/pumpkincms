<?php

class Csrf_protection {
	const TOKEN_NAME = 'csrf_token';
	
	static public function set_csrf_token() {
		if (PC_Config::get('csrf_protection')) {
			$_SESSION[self::TOKEN_NAME] = PC_Util::get_uuid_v4();
		}
	}
	
	static public function get_form_part() {
		if (empty($_SESSION[self::TOKEN_NAME])) {
			self::set_csrf_token();
		}
		if (PC_Config::get('csrf_protection')) {
			return sprintf('<input type="hidden" id="%s" name="%s" value="%s" />' . "\n", self::TOKEN_NAME, self::TOKEN_NAME, $_SESSION[self::TOKEN_NAME]);
		}
		return;
	}
	
	static public function validate() {
		if (empty(PC_Config::get('csrf_protection'))) {
			return true;
		}
		
		if (empty($_SESSION[self::TOKEN_NAME]) || empty($_POST[self::TOKEN_NAME])) {
			return false;
		}
		
		if ($_SESSION[self::TOKEN_NAME] != $_POST[self::TOKEN_NAME]) {
			return false;
		}
		
		return true;
	}
}
