<?php

class PumpUpload {
	const STORE_TYPE_LOCAL = 1;
	const STORE_TYPE_DB = 2;
	const STORE_TYPE_S3 = 3;

	public function mkdir_upload($code, $subdir='image') {
		return $this->mkdir_raw($code, 'upload', $subdir);
	}

	public function mkdir_raw($code, $dirname, $subdir='image') {
		$dir = PUMPCMS_APP_PATH . '/' . $dirname . '/' . $subdir . '/';
		if (is_dir($dir) == false) {
			mkdir($dir);
		}

		$dir .= 'site' . PC_Config::get('site_id') . '/';
		if (is_dir($dir) == false) {
			mkdir($dir);
		}

		$a = substr($code, 0, 1);
		$b = substr($code, 1, 1);

		$dir .= $a. '/';
		if (is_dir($dir) == false) {
			mkdir($dir);
		}
		$dir .= $b . '/';
		if (is_dir($dir) == false) {
			mkdir($dir);
		}

		return $dir;
	}

	static public function get_max_size() {
		$arr[0] = PC_Util::convert_size_rev(ini_get('post_max_size'));
		$arr[1] = PC_Util::convert_size_rev(ini_get('upload_max_filesize'));
		if (0 < PC_Config::get('upload_max_filesize')) {
			$arr[2] = PC_Config::get('upload_max_filesize');
		}

		sort($arr, SORT_NUMERIC);

		return $arr[0];
	}
}
