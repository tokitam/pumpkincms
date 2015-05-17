<?php
class PC_Abort {
	public static function abort($message='') {
		if (UserInfo::is_master_admin()) {
			var_dump(debug_backtrace());
		}
		die('Now maintenance. ' . $message);
	}
	
	public static function error($message, $file='', $line='') {
        die('die ' . $message . ', file:' . $file . ', line:' . $line);
	}
	
}

