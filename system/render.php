<?php

class PC_Render {
	public $module = '';
	public $class = '';
	public $method = '';
	public $module_output;
        public static $module_output_static;

	function __construct() {
		$this->set_variable();
	}

	public function module_render() {
		echo $this->module_output;
	}

	public function module_execute() {

		PC_Util::include_language_file($this->module);
		
		if ($this->class != '' && $this->method != '') {
			$class = $this->class;
			
			$obj = new $class();
			$method = $this->method;
			$obj->set_variable();

			if ($class != 'image_i' && method_exists($obj, $method) == false) {
				// mehtod not found
				require_once PUMPCMS_APP_PATH . '/module/index/controller/notfound.php';
				$obj = new index_notfound();
				$method = 'index';
			}

			$obj->$method();
		}
	}
	
	function render() {
		global $site_info;
	    
	    self::$module_output_static = $this->module_output;

		if (isset($_GET['system_layout'])) {
			PC_Config::set('layout', $_GET['system_layout']);
		}
	    
		if (SiteInfo::get('dir1') == 'admin') {
			include PUMPCMS_PUBLIC_PATH . '/themes/admin/theme.php';
		} else {
			ob_start();
			$file1 = PUMPCMS_PUBLIC_PATH . '/wpthemes/'  . PC_Config::get('layout') . '/index.php';
			$file1 = PUMPCMS_PUBLIC_PATH . '/themes/'  . PC_Config::get('layout') . '/theme.php';
			if (is_readable($file1)) {
				include $file1;
			} else {
				include $file2;
			}
			$out = ob_get_contents();
			ob_end_clean();
			echo $out;
		}
	}
	
	function set_variable() {
		$this->base_url = PC_Config::get('base_url');
	}
}

