<?php

require_once PUMPCMS_SYSTEM_PATH . '/pumpormap.php';
require_once PUMPCMS_SYSTEM_PATH . '/s3.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpupload.php';

class PumpFile extends PumpUpload {
	var $_target;
	var $_tmp_file;

	public function __constant() {
	}

	static public function get_type() {
		return intval(PC_Config::get('pumpfile_store_type'));
	}

	public function upload($target) {
		$code = PC_Util::random_code(8);

		$this->_target = $target;

		if (@$_FILES[$target]['tmp_name'] == '') {
			return 0;
		}
		if (! isset($_FILES[$target]['tmp_name'])) {
			return 0;
			//PC_Abort::abort('Image upload error');
		}

		$pumpormap = PumpORMAP_Util::get('file', 'file');

		//$this->check_type();
		$code = PC_Util::random_code(8);

		$dir = $this->mkdir_upload($code, 'file');
		$size = $_FILES[$target]['size'];

		$data = array(
			'site_id' => PC_Config::get('site_id'),
			'size' => $size,
			'code' => $code,
			'filename' => $_FILES[$target]['name'],
		);

		$file_id = $pumpormap->insert($data);
		$src_file = $_FILES[$target]['tmp_name'];

		if (self::get_type() == self::STORE_TYPE_LOCAL) {
			$dest_file =  $dir . '/' . $file_id . '_' . $code;

			move_uploaded_file($src_file, $dest_file);
		} else if (self::get_type() == self::STORE_TYPE_DB) {
			$db = PC_DBSet::get();
			$table = $pumpormap->get_table();
			$sql = sprintf(
				'INSERT INTO %s ' . 
				'(site_id, code, ip_address, filename, ' .
				' file, size, reg_time, reg_user) VALUES ' .
				'(?, ?, ?, ?, ?, ?, ?, ?)', $db->prefix($table));

			$stmt = $db->prepare($sql);

			$fp = fopen($_FILES[$target]['tmp_name'], 'rb');

			$site_id = PC_Config::get('site_id');
			$type = $this->_type;
			$ip_address = PC_Util::get_ip_address();
			$reg_time = time();
			$reg_user = UserInfo::get_id();

			$stmt->bindParam(1, $site_id);
			$stmt->bindParam(2, $code);
			$stmt->bindParam(3, $ip_address);
			$stmt->bindParam(4, $_FILES[$target]['name']);
			$stmt->bindParam(5, $fp, PDO::PARAM_LOB);
			$stmt->bindParam(6, $size);
			$stmt->bindParam(7, $reg_time);
			$stmt->bindParam(8, $reg_user);

			$db->beginTransaction();
			$ret1 = $stmt->execute();
			if ($db->get_driver() == PC_Db_pdo::PGSQL) {
				$file_id = $db->insert_id($db->prefix($table) . '_id_seq');
			} else {
				$file_id = $db->insert_id();
			}
			$ret2 = $db->commit();
		} else if (self::get_type() == self::STORE_TYPE_S3) {
			$dest_file =  $dir . '/' . $file_id . '_' . $code;			
			PC_S3::put($src_file, basename($dest_file));
		}

		return $file_id;
	}

	static public function get_tag($file_id) {
		$ormap = PumpORMAP_Util::get('file', 'file');
		$file = $ormap->get_one($file_id);
		$url = self::get_url($file_id);

		return sprintf('<a href="%s">%s</a>, size:%s', $url, htmlspecialchars($file['filename']), PC_Util::convert_size($file['size']));
	}

	static public function get_raw_url($file_id) {
		$ormap = PumpORMAP_Util::get('file', 'file');
		$file = $ormap->get_one($file_id);	

		$code = $file['code'];

		$url = PC_Config::get('base_url') . '/file/' . intval($image_id) . '_' . $code;
	}

	static public function get_url($file_id) {
		$url = PC_Config::url() . '/file/download/?id=' . intval($file_id);
		return $url;
	}

	public function get_download_path($file_id) {
    	$ormap = PumpORMAP_Util::get('file', 'file');
    	$file = $ormap->get($file_id);

    	if (self::get_type() == self::STORE_TYPE_LOCAL) {
	    	$dir = $this->mkdir_upload($file['code'], 'file');
			$dest_file =  $dir . '/' . $file['id'] . '_' . $file['code'];
		} else if (self::get_type() == self::STORE_TYPE_DB) {
			$dest_file = tempnam(sys_get_temp_dir(), 'pump');
			file_put_contents($dest_file, $file['file']);
			$this->_tmp_file = $dest_file;
		} else if (self::get_type() == self::STORE_TYPE_S3) {
			$src_file = $file['id'] . '_' . $file['code'];
			$dest_file = PC_S3::get($src_file);
			$this->_tmp_file = $dest_file;
		}

		return $dest_file;
	}

	public function post_process() {
		if (self::get_type() == self::STORE_TYPE_DB ||
			self::get_type() == self::STORE_TYPE_S3) {
			unlink($this->_tmp_file);
		}
	}
}