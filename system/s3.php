<?php

require_once PUMPCMS_ROOT_PATH . '/external/tpyo-amazon-s3-php-class/S3.php';

class PC_S3 {
	static private $_s3 = false;

	static private function connect() {
		if (self::$_s3 != false) {
			return;
		}

		self::$_s3 = new S3(
			PC_Config::get('aws_access_key'),
			PC_Config::get('aws_secret_key')
			);
	}

	static public function get($s3_file) {
		self::connect();

		$temp = tempnam(sys_get_temp_dir(), 'pumpcms');
		self::$_s3->getObject(
			PC_Config::get('aws_s3_bucket_name'), 
			$s3_file, 
			fopen($temp, 'wb')
			);

		return $temp;
	}

	static public function put($upload_file, $s3_file) {
		self::connect();

		self::$_s3->putObjectFile(
			$upload_file, 
			PC_Config::get('aws_s3_bucket_name'), 
			$s3_file, 
			S3::ACL_PUBLIC_READ
			);
	}

	static public function delete($upload_file, $s3_file) {
		self::connect();

		self::$_s3->deleteObjectFile(
			PC_Config::get('aws_s3_bucket_name'), 
			$s3_file
			);
	}
}
