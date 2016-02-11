<?php

class OAuth_util {
	static public function get_tag() {
		// ここでディレクトリを読んでループ
		self::require_file('twitter');
		$oauth = self::get_object('twitter');
		return array($oauth->get_tag());
	}

	static public function load_oauth_class() {
		if (@$_SESSION['oauth_type'] && preg_match('/^[a-z]+$/', $_SESSION['oauth_type'])) {
			$type = $_SESSION['oauth_type'];
			$file =  PUMPCMS_APP_PATH . '/module/user/plugin/' . $type . '/oauth.php';
			require_once $file;
			return self::get_object($type);
		}

		if (@$_GET['type'] && preg_match('/^[a-z]+$/', $_GET['type'])) {
			$type = $_GET['type'];
			$file =  PUMPCMS_APP_PATH . '/module/user/plugin/' . $type . '/oauth.php';
			require_once $file;
			return self::get_object($type);
		}
	}

	static public function require_file($type) {
		if (! preg_match('/^[a-z]+$/', $type)) {
			throw new Exception('Not found oauth class:' . $type);
		}

		$file =  PUMPCMS_APP_PATH . '/module/user/plugin/' . $type . '/oauth.php';
		if (is_readable($file)) {
			require_once $file;
		}
	}

	static public function get_object($type) {
		if (! preg_match('/^[a-z]+$/', $type)) {
			throw new Exception('Not found oauth class:' . $type);
		}

		$class_name = 'OAuth_' . $type;

		return new $class_name();
	}
}
