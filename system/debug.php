<?php

class PC_Debug {
	static $flg_debug = true;
	static $limit = 1000;

	static function set_debug($flg) {
		self::$flg_debug = $flg;
	}

	static function log($str, $file, $line) {
		if (PC_Config::get('debug_mode') == false) {
			return;
		}

		$m = microtime();
		$s = explode(' ', $m);
		$log = strftime('%X %X', time()) . ' ' . $s[0] . ' ' . $str . ' ' . $file . ':' . $line;

		if (is_array(@$_SESSION['pump_'. PC_Config::get('site_id')]['debug']) == false) {
			$_SESSION['pump_'. PC_Config::get('site_id')]['debug'] = array();
		}

		array_push($_SESSION['pump_'. PC_Config::get('site_id')]['debug'], $log);

		self::log_file($log);
	}

	static function get_log() {
		return $_SESSION['pump_'. PC_Config::get('site_id')]['debug'];
	}

	static function limit() {
		for ($i=0; $i<1000; $i++) {
			if (self::$limit < count($_SESSION['pump_'. PC_Config::get('site_id')]['debug'])) {
				array_shift($_SESSION['pump_'. PC_Config::get('site_id')]['debug']);
			}
		}
	}

	static function output() {
		if (PC_Config::get('debug_mode') == false) {
			return;
		}
		self::limit();

		echo "<hr />\n";
		echo "<div style='text-align:left;'>\n";
		echo "debug<br />\n";

		$debug = array_reverse(self::get_log());
		foreach ($debug as $key => $line) {
			echo "$line<br />\n";
		}

		echo "</div>\n";
	}

	static function log_file($log) {
		$filename = self::get_log_file();

		if (! is_readable($filename)) {
			return;
		}

		if (! is_writable($filename)) {
			return;
		}

		$fp = @fopen($filename, 'a');
		if ($fp == false) {
			return;
		}

		fputs($fp, $log . "\n");
		fclose($fp);
	}

	static function get_log_file() {
		return PC_Config::get('log_dir') . strftime('/pumpcms-%Y-%m-%d.log', time());
	}
}
