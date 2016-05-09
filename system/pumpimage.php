<?php

require_once PUMPCMS_SYSTEM_PATH . '/pumpormap.php';
require_once PUMPCMS_SYSTEM_PATH . '/s3.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpupload.php';

class PumpImage extends PumpUpload {
	const TYPE_JPG = 1;
	const TYPE_PNG = 2;
	const TYPE_GIF = 3;
	const TYPE_UNKNOWN = 4;

	var $_type;
	var $_target;

	static public function get_type() {
		return intval(PC_Config::get('pumpimage_store_type'));
	}

	static public function get_tag($image_id, $width=0, $height=0, $option=array()) {
		$arr = self::get_url_raw($image_id, $width, $height, $option);
		if ($arr == false) {
			return self::display_no_image($width, $height, $option);
		}

		$url = @$arr['url'];
		$image= @$arr['data'];
		$wh = @$arr['wh'];
		$org_size = @$arr['org_size'];

		$org_size .= '.' . self::get_ext($image['type']);

		if (@$option['link']) {
			$a_option = '';
			if (@$option['rel']) {
				$a_option .= ' rel="lightbox" ';
			}

			$tag = sprintf('<a href="%s" target="_blank" %s><img src="%s"%s></a>', $org_size, $a_option, $url, $wh);
		} else {
			$tag = sprintf('<img src="%s"%s>', $url, $wh);
		}			

		return $tag;
	}

	static public function get_image_url($image_id, $width=0, $height=0, $option=array()) {
		$arr = self::get_url_raw($image_id, $width, $height, $option);
		if ($arr == false) {
			return self::get_no_image_url();
		}

		return $arr['url'];
	}

	static public function get_url_raw($image_id, $width=0, $height=0, $option=array()) {
		global $pumpform_config;

		PC_Util::include_language_file('image');
		PumpFormConfig::load_config('image');
		$pumpormap = new PumpORMAP($pumpform_config['image']['image']);

		$image = $pumpormap->get_one($image_id, 'id, site_id, width, height, type, code');

		if ($image == false) {
			return false;
		}

		if ($height == 0) {
			if ($image['width'] > $width) {
				$height = $image['height'] * $width / $image['width'];
			} else if ($width > $image['width']) {
				$height = $image['height'] * $image['width'] / $width;
			} else {
				$height = $image['height'];
			}
		}

		if ($width == 0) {
			if ($image['height'] > $height) {
				$width = $image['width'] * $height / $image['height'];
			} else if ($height > $image['height']) {
				$width = $image['width'] * $image['height'] / $height;
			} else {
				$width = $image['width'];
			}
		}

		$image_id = $image['id'];
		$code = trim($image['code']);
		$ext = self::get_ext($image['type']);

		if (self::get_type() == self::STORE_TYPE_LOCAL) {
			$file_path = self::get_upload_image($image_id, $code, $ext);
			if (is_readable($file_path) == false) {
				return '';
			}
		}

		$styles = array();
		$url = PC_Config::get('base_url') . '/image/i/' . intval($image_id) . '_' . $code;
		$org_size = $url;
		$wh = '';

		if (0 < $width) {
		    $url .= '_' . intval($width) . 'x' . intval($height);
		    if (@$option['no_wh'] == 0) {
		    	//$wh = sprintf(' width="%d" height="%d" ', $width, $height);
			    $styles['width'] = intval($width);
			    $styles['height'] = intval($height);
			}
		} else if (@$option['width100p']) {
			$wh = ' width="100%"';
		}
		if (@$option['css_width']) {
			$styles['width'] = intval($option['css_width']) . 'px';
			$styles['height'] = intval($option['css_height']) . 'px';
		}
		if (@$option['float']) {
			//$wh .= ' style="float: left;"';
			$styles['float'] = "'left'";
		}
		if (@$option['align']) {
			$wh .= ' align="' . $option['align'] . '" ';
		}
		if (0 < count($styles)) {
			$tmp = array();
			foreach ($styles as $key => $val) {
				array_push($tmp, $key . ':' . $val);
			}
			$wh .= ' style="' . implode($tmp, '; ') . ';" ';
		}
		if (@$option['crop']) {
			$url .= '_c';
		}
		if (@$option['class']) {
			$wh .= ' class="' . $option['class'] . '" ';
		}
		$url .= '.' . self::get_ext($image['type']);

		return array('url' => $url, 'data' => $image, 'wh' => $wh, 'org_size' => $org_size);
	}

	static public function get_url($image_id, $width=0, $height=0, $option=array()) {
		$arr = self::get_url_raw($image_id, $width, $height, $option);
		if ($arr == false) {
			return false;
		} else {
			return $arr['url'];
		}
	}

	function upload($target) {
		global $pumpform_config;

		$this->_target = $target;

		if (@$_FILES[$target]['tmp_name'] == '') {
			return 0;
		}
		if (! isset($_FILES[$target]['tmp_name'])) {
			return 0;
			//PC_Abort::abort('Image upload error');
		}

		$pumpormap = PumpORMAP_Util::get('image', 'image');
	    
	        $imagesize = getimagesize($_FILES[$target]['tmp_name']);
	        $width = $imagesize[0];
	        $height = $imagesize[1];

		$this->check_type();
		$code = PC_Util::random_code(8);

    	//if (self::get_type() == self::STORE_TYPE_LOCAL) {
			$dir = $this->mkdir_upload($code);
		//}

		$db = PC_DBSet::get();
		$table = $pumpormap->get_table();
		
		if (self::get_type() == self::STORE_TYPE_LOCAL ||
			self::get_type() == self::STORE_TYPE_S3) {
			$data = array(
				'site_id' => PC_Config::get('site_id'),
				'type' => $this->_type,
				'code' => $code,
				'width' => $width,
				'height' => $height
				);

			$image_id = $pumpormap->insert($data);

		} else if (self::get_type() == self::STORE_TYPE_DB) {
			$site_id = PC_Config::get('site_id');
			$type = $this->_type;
			$ip_address = PC_Util::get_ip_address();
			$reg_time = time();
			$reg_user = UserInfo::get_id();

			if (PC_DBSet::get_db_type() == 'mysql') {
				$image_column = '?';
			} else {
				// PDO
				$image_column = ':image';
			}

			$sql = sprintf(
				'INSERT INTO %s ' . 
				'(site_id, width, height, type, code, ip_address, ' . 
				'image, reg_time, reg_user) VALUES ' .
				'(%d, %d, %d, %d, \'%s\', %d, %s, %d, %d)', 
				$db->prefix($table),
				$site_id,
				$width,
				$height,
				$type,
				$code,
				$ip_address,
				$image_column,
				$reg_time,
				$reg_user
				);

			$stmt = $db->prepare($sql);
			
			$fp = fopen($_FILES[$target]['tmp_name'], 'rb');

			try {
				if (PC_DBSet::get_db_type() == 'mysql') {
					$tmp = file_get_contents($_FILES[$target]['tmp_name']);
					$null = NULL;
					$stmt->bind_param('b', $null);
					$stmt->send_long_data(0, $tmp);
				} else {
					$stmt->bindParam(':image', $fp, PDO::PARAM_LOB);
				}

				$ret1 = $stmt->execute();

				if ($db->get_driver() == PC_Db_pdo::PGSQL) {
					$image_id = $db->insert_id($db->prefix($table) . '_id_seq');
				} else {
					$image_id = $db->insert_id();
				}

			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}

		$src_file = $_FILES[$target]['tmp_name'];
		$dest_file =  $dir . '/' . $image_id . '_' . $code . '.' . self::get_ext($this->_type);

		if (self::get_type() == self::STORE_TYPE_LOCAL) {
			move_uploaded_file($src_file, $dest_file);
		} else if (self::get_type() == self::STORE_TYPE_S3) {
			PC_S3::put($src_file, basename($dest_file));
		}

		return $image_id;
	}

	public function display_image($name) {
		if (preg_match('/^nc.png$/', $name)) {
			$this->display_not_found_image();
			return;
		}
		if (preg_match('/^(\d+)_([0-9A-Za-z]+)\.(jpg|png|gif)/', $name, $r)) {
			$image_id = $r[1];
			$code = $r[2];
			$ext = $r[3];

			//$file_path = $this->get_upload_image($image_id, $code, $ext);
			$file_path = $this->create_cache_file($image_id, $code, $ext, null, null);

			
		} else if (preg_match('/^(\d+)_([0-9A-Za-z]+)_(\d+)x(\d+)\.(jpg|png|gif)/', $name, $r)) {
			$image_id = $r[1];
			$code = $r[2];
			$width = $r[3];
			$height = $r[4];
			$ext = $r[5];

			$file_path = $this->create_cache_file($image_id, $code, $ext, $width, $height);

		} else if (preg_match('/^(\d+)_([0-9A-Za-z]+)_(\d+)x(\d+)_([cei])\.(jpg|png|gif)/', $name, $r)) {
			$image_id = $r[1];
			$code = $r[2];
			$width = $r[3];
			$height = $r[4];
			$method = $r[5];
			$ext = $r[6];
			
			$file_path = $this->create_cache_file($image_id, $code, $ext, $width, $height, $method);
		} else {
			return;
		}

		if (@$_GET['no_image_header'] == '') {
			$expires = (60 * 60 * 24 * 365);
			header('Expires: ' . gmdate('D, d M Y H:i:s T', time() + $expires));
			header('Cache-Control: private, max-age=' . $expires);
			if ($ext == 'jpg') {
				header('Content-type: image/jpeg');
			} else if($ext == 'png') {
				header('Content-type: image/png');
			} else if($ext == 'gif') {
				header('Content-type: image/gif');
			}
		}

		readfile($file_path);
		exit();
	}

	public function create_cache_file($image_id, $code, $ext, $r_width, $r_height, $method='i') {
    	$this->mkdir_cache($code);

    	$dest_image = $this->get_cache_image($image_id, $code, $ext, $r_width, $r_height, $method);

    	if (1600 < $r_width || 1600 < $r_height) {
    		PC_Abort::error('Image size over');
    	}

    	if (@$_GET['nocache']=='' && is_readable($dest_image)) {
    		return $dest_image;
    	}

    	if (self::get_type() == self::STORE_TYPE_DB) {
			$src_image = tempnam(sys_get_temp_dir(), 'tmpimage');
			$ormap = PumpORMAP_Util::getInstance('image', 'image');
			$image = $ormap->get_one($image_id);

			if ($image['image'] == '') {
	    		$src_image = $this->get_upload_image($image_id, $code, $ext);
			} else {
				file_put_contents($src_image, $image['image']);
			}
    	} else if (self::get_type() == self::STORE_TYPE_LOCAL) {
    		// from local disk
    		$src_image = $this->get_upload_image($image_id, $code, $ext);
		} else if (self::get_type() == self::STORE_TYPE_S3) {
    		// from aws s3
    		$src_image = $this->get_upload_image($image_id, $code, $ext);
    		$src_image = PC_S3::get(basename($src_image));
       	}

    	if ($r_width == null && $r_height == null) {
    		copy($src_image, $dest_image);
        	if (self::get_type() == self::STORE_TYPE_DB) {
        		self::delete_tmp_file($src_image);
	        } else if (self::get_type() == self::STORE_TYPE_S3) {
	        	unlink($src_image);
	        }
    		return $dest_image;
    	}

		if ($ext == 'jpg'){
			$function_image_create = 'ImageCreateFromJpeg';
    	    $function_image = 'ImageJpeg';
 		} else if ($ext == 'png') {
  	    	$function_image_create = 'ImageCreateFromPng';
 	    	//$function_image = 'ImagePng';
 	    	$function_image = 'ImageJpeg';
 	    	$ext = 'jpg';
		} else if ($ext == 'gif') {
			$function_image_create = 'ImageCreateFromGif';
			$function_image = 'ImageGif';
		}

		$im_in = $function_image_create($src_image);
	    $size = getimagesize($src_image);

    	if ($size == false) {
        	// not image file

        	if (self::get_type() == self::STORE_TYPE_DB) {
        		self::delete_tmp_file($src_image);
        	}

    	    return;
	    }

	    $width = $size[0];
    	$height = $size[1];

    	$src_w = $width;
    	$src_h = $height;

    	if ($method == 'i') {
    		// be inscribed.
    		// 内接するように拡大する

	    	if (($r_width / $width) * $height < $r_height) {
    			$dest_w = $r_width;
    			$dest_h = ($r_width / $width) * $height;

	    		$dest_x = 0;
    			$src_x = 0;

	    		if ($r_height < $dest_h) {
					$dest_y = ($dest_h - $r_height) / 2;
    			} else {
    				$dest_y = ($r_height - $dest_h) / 2;
	    		}	
    			$src_y = 0;

	    	} else {
    			$dest_w = ($r_height / $height) * $width;
    			$dest_h = $r_height;

	    		if ($dest_w < $r_width) {
					$dest_x = ($r_width - $dest_w) / 2;
    			} else {
    				$dest_x = ($dest_w - $r_width) / 2;
	    		}
    			$src_x = 0;

	    		$dest_y = 0;
    			$src_y = 0;
    		}

	    } else if ($method == 'c') {
	    	// 中心を拡大する

			$dest_w = $r_width;
			$dest_h = $r_height;

			$gap_w = $src_w / $dest_w;
			$gap_h = $src_h / $dest_h;

			if ($gap_w < $gap_h) {
    			$cut = ceil((($gap_h - $gap_w) * $dest_h) / 2);
    			$dest_x = 0;
    			$dest_y = 0;
    			$src_x = 0;
    			$src_y = $cut;
    			//$dest_w 
    			//$dest_h  
    			//$src_w
    			$src_h = $src_h - ($cut * 2);

			} else if ($gap_h < $gap_w) {
			    $cut = ceil((($gap_w - $gap_h) * $dest_w) / 2);
			    $dest_x = 0;
			    $dest_y = 0;
			    $src_x = $cut;
			    $src_y = 0;
			    //$dest_w
			    //$dest_h
			    $src_w = $src_w - ($cut * 2);
			    //$src_h
			} else {
				$dest_x = 0;
				$dest_y = 0;
				$src_x = 0;
				$src_y = 0;
				//$dest_w 
				//$dest_h
				//$src_w
				//$src_h
			}
	    }

		$im_out = imagecreatetruecolor($r_width, $r_height);
		$white = imagecolorallocate($im_out, 255, 255, 255);
		imagefilledrectangle($im_out, 0, 0, $r_width, $r_height, $white);

    	$resize = imagecopyresampled($im_out, $im_in, $dest_x, $dest_y, $src_x, $src_y, $dest_w, $dest_h, $src_w, $src_h);
    	//$resize = imagecopyresized($im_out, $im_in, $dest_x, $dest_y, $src_x, $src_y, $dest_w, $dest_h, $src_w, $src_h);
		$function_image($im_out, $dest_image, 90);

		imagedestroy($im_in);
		imagedestroy($im_out);

        if (self::get_type() == self::STORE_TYPE_DB) {
        	self::delete_tmp_file($src_image);
        }

		return $dest_image;
	}

	public function mkdir_upload($code, $subdir='image') {
		return $this->mkdir_raw($code, 'upload');
	}

	public function mkdir_cache($code) {
		$dir = PUMPCMS_PUBLIC_PATH . '/image/i/';
		if (is_dir($dir) == false) {
			mkdir($dir);
		}
	}

	public function mkdir_raw($code, $dirname, $subdir='image') {
		$dir = PUMPCMS_APP_PATH . '/' . $dirname . '/image/';
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

	public function check_type() {
		if ($_FILES[$this->_target]['type'] == 'image/jpeg') {
			$this->_type = self::TYPE_JPG;
		} else if ($_FILES[$this->_target]['type'] == 'image/png') {
			$this->_type = self::TYPE_PNG;
		} else if ($_FILES[$this->_target]['type'] == 'image/gif') {
			$this->_type = self::TYPE_GIF;
		} else {
			$this->_type = self::TYPE_UNKNOWN;
		}
	}

	static public function get_ext($type) {
		if ($type == self::TYPE_JPG) {
			return 'jpg';
		}
		if ($type == self::TYPE_PNG) {
			return 'png';
		}
		if ($type == self::TYPE_GIF) {
			return 'gif';
		}
	}

	static public function get_upload_image($id, $code, $ext) {
		return self::get_raw_image($id, $code, $ext, 'upload');
	}

	static public function get_cache_image($id, $code, $ext, $r_width=0, $r_height=0, $method) {
		//return self::get_raw_image($id, $code, $ext, 'cache', $r_width, $r_height);
		$file = PUMPCMS_PUBLIC_PATH . '/image/i/' . self::get_base_cache_image($id, $code, $ext, 'cache', $r_width, $r_height, $method);
		return $file;
	}

	static public function get_raw_image($id, $code, $ext, $dirname, $r_width=0, $r_height=0) {
		return PUMPCMS_APP_PATH . self::get_base_image($id, $code, $ext, $dirname, $r_width, $r_height);
	}

	static public function get_base_image($id, $code, $ext, $dirname, $r_width=0, $r_height=0) {
		$a = substr($code, 0, 1);
		$b = substr($code, 1, 1);

		$tmp = '/' . $dirname . '/image/site' . PC_Config::get('site_id') . '/'. $a . '/' . $b . '/';
		$tmp .= $id . '_' . $code;
		if ($dirname == 'cache' && (0 < $r_width || 0 < $r_height)) {
			$tmp .= '_' . intval($r_width) . 'x' . intval($r_height);
		}
		$tmp .= '.' . $ext;

		return $tmp;
	}

	static public function get_base_cache_image($id, $code, $ext, $dirname, $r_width=0, $r_height=0, $method) {
		$tmp = $id . '_' . $code;
		if ($dirname == 'cache' && (0 < $r_width || 0 < $r_height)) {
			$tmp .= '_' . intval($r_width) . 'x' . intval($r_height);
		}
		if ($method == 'c') {
			$tmp .= '_c';
		}
		$tmp .= '.' . $ext;

		return $tmp;
	}

	static public function get_no_image_url() {
		return PC_Config::url() . '/image/i/nc.png';
	}

    static public function display_no_image($width, $height, $option) {
    	$url = self::get_no_image_url();
    	$tag = sprintf('<img src="%s" width="%d" height="%d">', $url, $width, $height);
    	return $tag;
    }

    static public function display_not_found_image() {
    	if (PC_Config::get('under_construction_image')) {
			$file = PC_Config::get('under_construction_image');
    	} else {
			$file = PUMPCMS_ROOT_PATH . '/resource/uc.png';
    	}
    	header('Content-type: image/png');
    	readfile($file);
    	exit();
   }

   /**
    * 一次ファイルのみ削除する
    */
   static public function delete_tmp_file($image_file) {
   		$tmp_dir = sys_get_temp_dir();
   		$pos = strpos($image_file, $tmp_dir);
   		if ($pos === false) {
   			// do nothing
   		} else {
			@unlink($image_file);
   		}
   }
}
