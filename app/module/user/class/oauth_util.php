<?php

class OAuth_util {
	static public function get_tag() {
		// ここでディレクトリを読んでループ
		//self::require_file('twitter');
		//$oauth = self::get_object('twitter');

		$tag_list = [];

		$dir = PUMPCMS_APP_PATH . '/module/user/plugin';

		if (is_dir($dir)) {
			if ($dh = opendir($dir)) {
				while (($file = readdir($dh)) !== false) {
					if (preg_match('/^[a-z]+$/', $file)) {
						self::require_file($file);
						$oauth = self::get_object($file);
						array_push($tag_list, $oauth->get_tag());
					}
				}
				closedir($dh);
			}
		}

		//return array($oauth->get_tag());
		return $tag_list;
	}

	static public function load_oauth_class() {
		var_dump($_POST);
		if (@$_SESSION['oauth_type'] && preg_match('/^[a-z]+$/', $_SESSION['oauth_type'])) {
			$type = $_SESSION['oauth_type'];
			self::require_file($type);
			return self::get_object($type);
		}

		if (@$_GET['type'] && preg_match('/^[a-z]+$/', $_GET['type'])) {
			$type = $_GET['type'];
			self::require_file($type);
			return self::get_object($type);
		}

		if (@$_POST['type'] && preg_match('/^[a-z]+$/', $_POST['type'])) {
			$type = $_POST['type'];
			self::require_file($type);
			return self::get_object($type);
		}

		throw new Exception('Not found oauth class');
	}

	static public function require_file($type) {
		if (! preg_match('/^[a-z]+$/', $type)) {
			throw new Exception('Not found oauth class:' . $type);
		}

		$file =  PUMPCMS_APP_PATH . '/module/user/plugin/' . $type . '/oauth_' . $type . '.php';

		if (! is_readable($file)) {
			throw new Exception('Not found oauth class:' . $file);
		}

		require_once $file;
	}

	static public function get_object($type) {
		if (! preg_match('/^[a-z]+$/', $type)) {
			throw new Exception('Not found oauth class:' . $type);
		}

		$class_name = 'OAuth_' . $type;

		return new $class_name();
	}
}
