<?php

class PC_Util {
	static function redirect($url) {
		header('Location: ' . $url);
		exit();
	}
    
	static function is_email($email) {
		if (preg_match('|^[0-9a-z_./?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$|', $email)) {
			return true;
		} else {
			return false;
		}
	}
    
	static function is_url($url) {
		if (preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $url)) {
			return true;
		} else {
			return false;
		}
	}

	static function is_twitterid($twitterid) {
		if (preg_match('/^\@([0-9A-Za-z]+)$/', $twitterid, $r)) {
			return true;
		} else {
			return false;
		}
	}
    
	static function mail($to, $subject, $message) {

		mb_internal_encoding('UTF-8');

		$subject = preg_replace('/\[site_title\]/', PC_Config::get('site_title'), $subject);
		$subject = preg_replace('/\[base_url\]/', PC_Config::get('base_url'), $subject);
		$subject = mb_encode_mimeheader($subject, 'ISO-2022-JP-MS');
		$message = preg_replace('/\[site_title\]/', PC_Config::get('site_title'), $message);
		$message = preg_replace('/\[base_url\]/', PC_Config::get('base_url'), $message);
		$message = mb_convert_encoding($message, 'ISO-2022-JP-MS');


		$headers = 'From: ' . PC_Config::get('from_email') . "\r\n" .
		      'Reply-To: ' . PC_Config::get('from_email') . "\r\n" . 
		  'Content-Transfer-Encoding: 7bit' . "\r\n" .
		  'Content-Type: text/plain; charset="iso-2022-jp"' . "\r\n";
		  
		mail($to, $subject, $message, $headers);
	    
	}

	static function random_code($length) {
		$str = '0123456789abcdefghijklmnopqrstuvwxyz';

		$max = strlen($str);

		$s = '';
		for ($i=0; $i < $length; $i++) {
			$s .= substr($str, rand(0, $max - 1), 1);
		}

		return $s;
	}

	static function include_language_file($module) {
		$lang_file = PUMPCMS_APP_PATH . '/module/' . $module . '/language/' . PC_Config::get('language') . '/main.php';
		$english_file = PUMPCMS_APP_PATH . '/module/' . $module . '/language/english/main.php';
	
		if (file_exists($lang_file)) {
			require_once $lang_file;
		} else if (file_exists($english_file)) {
			require_once $english_file;
		}
	}

	static function ref_values($arr){ 
		if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+ 
		{ 
			$refs = array(); 
			foreach($arr as $key => $value) 
				$refs[$key] = &$arr[$key]; 
			return $refs; 
		} 
		return $arr; 
	} 

	static function is_top_page() {
		if (PC_Config::get('service_url') == '') {
			return true;
		}

		return false;
	}

	static function get_ip_address() {
		/*
		if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])
		 	&& $_SERVER['HTTP_X_FORWARDED_FOR'] != @$_SERVER['REMOTE_ADDR']) {
			  $HTTP_SERVER_VARS['REMOTE_ADDR'] = $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'] = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		*/
		return @$_SERVER['REMOTE_ADDR'];
	}

	static function get_useragent() {
		return @$_SERVER['HTTP_USER_AGENT'];
	}
    
        static function get_service_base_path() {
	    if ($_SERVER['REQUEST_URI'] == '' ||
		$_SERVER['REQUEST_URI'] == '/') {
		return '';
	    } else if ($_SERVER['QUERY_STRING'] == '') {
		preg_match('@(.+)/?@', $_SERVER['REQUEST_URI'], $r);
		return self::cut_tail_slash($r[1]);
	    } else {
		$q = self::cut_tail_slash($_SERVER['QUERY_STRING']);
		if (strstr($q, '=')) {
		    $arr = explode('=', $q);
		    $q = $arr[1];
		}
		$req = self::cut_tail_slash($_SERVER['REQUEST_URI']);
//echo "<br />\n";		
//echo "<br />\n";		
//echo "<br />\n";		
//		echo " q: " . $q . "\n";
//		echo " req: " . $req . "\n"; 

		preg_match('@(.+)/' . $q . '$@', $req, $r);
//var_dump($r);
//		var_dump($_SERVER);
		return $r[1];
	    }
	}
    
        static function cut_tail_slash($s) {
	    $l = substr($s, -1, 1);
	    if ($l == '/') {
		return substr($s, 0, -1);
	    }
	    
	    return $s;
	}

	static function strip_tags($str) {
		$tags = array('a', 'p', 'span', 'em', 'iframe', 'img', 'li', 
			      'ol', 'br', 'hr',  'script',
			      'table', 'tr', 'td', 'th');
		$t = '';
		foreach ($tags as $i) {
			$t .= '<' . $i . '>';
		}
		return strip_tags($str, $t);
	}

	static function split_pagebreak($str) {
		if (preg_match('/^(.+)<!-- pagebreak -->(.+)$/s', $str, $r)) {
			return $r[1];
		} else {
			return $str;
		}
	}

	static function get_module_url() {
		if (PumpForm::$scaffold_base_url != '') {
			$module_url = PumpForm::$scaffold_base_url;
		} else {
			$module_url = PC_Config::url() . '/' . PC_Config::get('dir1');
			if (PC_Config::get('dir2') != '') {
				$module_url .= '/' . PC_Config::get('dir2');
			} else {
				$module_url .= '/index';
			}
		}

		return $module_url;
	}

	static public function is_admin_dir() {
		if (preg_match('@^admin/@', PC_Config::get('service_url'))) {
			return true;
		} else {
			return false;
		}
	}
    
	static public function is_smartphone() {
		$ua = $_SERVER["HTTP_USER_AGENT"];

		if (strpos($ua, 'Android') != false) {
			if (strpos($ua, 'Mobile') != false) {
				return true;
			}
		} else if (strpos($ua, 'iPhone') != false) {
			return true;
		}

		return false;
	}

	static public function mb_truncate($str, $len=60) {
		if (mb_strlen($str) <= $len) {
			return $str;
		}

		return mb_substr($str, 0, $len) . '...';
	}
    
	static function convert_size($size) {
		if ($size < 1024) {
			return $size;
		}
		
		if ($size < 1024 * 1024) {
			return (intval(10 * $size / 1024) / 10) . 'KB';
		}
		
		if ($size < 1024 * 1024 * 1024) {
			return (intval(10 * $size / 1024 / 1024) / 10) . 'MB';
		}
		
		// over 1TB 
		return (intval(10 * $size / 1024 / 1024 / 1024) / 10) . 'TB';
	}

	static function convert_size_rev($size) {
		if (preg_match('/([0-9]+)([KMT])/i', $size, $r)) {
			// do nothing
		} else {
			return $size;
		}

		if ($r[2] == 'K') {
			return $r[1] * 1024;
		}

		if ($r[2] == 'M') {
			return $r[1] * 1024 * 1024;
		}

		if ($r[2] == 'T') {
			return $r[1] * 1024 * 1024 * 1024;
		}

		return $r[1];
	}
}
