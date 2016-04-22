<?php

require_once PUMPCMS_SYSTEM_PATH . '/render.php';
require_once PUMPCMS_SYSTEM_PATH . '/multi_lang.php';
require_once PUMPCMS_SYSTEM_PATH . '/multi_site.php';
require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';

class PC_Main {
	var $_dir1 = '';
	var $_dir2 = '';
	var $_dir3 = '';
	var $_dir4 = '';
	var $_module = '';
	var $_controller = '';
	var $_method = '';
	var $_output = '';
	var $_module_output = '';
	
	var $render;
	
	function __construct() {
	}
	
	function run() {
		global $site_info;

		$this->setup();
		$this->check_site();
		$this->check_lang();
		$this->load_config();
		$this->render = new PC_Render();
		$this->analyze_url();
		$this->execute();
		$this->render->render();

		if (PC_Config::get('debug_mode') && PC_Config::get('display_log')) {
			PC_Debug::output();
		}
	}
	
	function setup() {
		mb_language('Japanese');
		mb_internal_encoding('UTF-8');
		date_default_timezone_set('UTC');
	}

	function load_config() {
		PC_Config::load_config();
	}

	function check_site() {
		PC_MultiSite::console_setup();
		PC_MultiSite::check_site();
	}
    
	function check_lang() {
		PC_MultiLang::check_lang();
		PC_Config::set('language', $_SESSION['lang']);
		PC_Util::include_language_file('pumpform');
		PC_Util::include_language_file('user');
	}
    
	function analyze_url() {
		global $site_info;

	    //PC_Config::set('REQUEST_URI', $_SERVER['REQUEST_URI']);

	    if (preg_match('@^(.+)\?(.*)$@', $_SERVER['REQUEST_URI'], $r)) {
			$request_uri = @$r[1];
		} else {
		    $request_uri = $_SERVER['REQUEST_URI'];
		}

		$base_path = SiteInfo::get_path();

		preg_match('@(' . $base_path . ')(.*)@', $request_uri, $r);
		$service_url = @$r[2];
		PC_Config::set('service_url', $service_url);

		$router_no = PC_Config::get('router_no');
		$router_list = PC_Config::get('router', $router_no);

		if (SiteInfo::is_site_close()) {
			if (UserInfo::is_logined() && 
				UserInfo::is_master_admin() == false) {
				$user_model = new user_model();
				$user_model->logout();
				PC_Util::redirect_top();
			}

			if (UserInfo::is_master_admin()) {
				// master admin
				// do nothing
			} else {
				// no master admin
				$this->_module = 'user';
				$this->_controller = 'index';
				$this->_method = 'index';
				if (!preg_match('/login/', $_SERVER['REQUEST_URI'])) {
					$_SESSION['from_url'] = $_SERVER['REQUEST_URI'];
				}
				return;
			}
		}

		$ret = null;
		if (is_array($router_list)) {
			foreach ($router_list as $module) {
			    if (is_array($module)) {
				continue;
			    }
				$file = PUMPCMS_APP_PATH . '/module/' . $module . '/router/' . $module . '_router.php';
				if (is_readable($file)) {
					require_once $file;

					$classname = $module . '_router';

					$class = new $classname();
					$ret = $class->router($service_url);

					if ($ret) {
						break;
					}
				}
			}
		}

		if ($ret != null) {
			$this->_module = $ret['module'];
			$this->_controller = $ret['controller'];
			$this->_method = $ret['method'];
			$theme = @$ret['theme'];
			if ($theme != '') {
				PC_Config::set('theme', $theme);
			}

			return;
		}

		$d = explode('/', @$service_url);
		if (@$d[0] != '') {
			$this->_dir1 = $d[0];
		}
		if (@$d[1] != '') {
			$this->_dir2 = $d[1];
		}
		if (@$d[2] != '') {
			$this->_dir3 = $d[2];
		}
		if (@$d[3] != '') {
			$this->_dir4 = $d[3];
		}

		if ($this->_dir1 == '') {
			$this->_module = SiteInfo::dir2module('/');
		} else {
			$r = preg_replace('@/@', '', SiteInfo::dir2module($this->_dir1));
			$this->_module = $r;
			SiteInfo::set('dir', $this->_dir1);
		}
		if ($this->_dir2 == '') {
		        $this->_controller = PC_Config::get('default_controller');
		} else {
			$this->_controller = $this->_dir2;
		}
		if ($this->_dir3 == '') {
			$this->_method = 'index';
		} else {
			$this->_method = $this->_dir3;
		}

		SiteInfo::set('dir1', $this->_dir1);
		SiteInfo::set('dir2', $this->_dir2);
		SiteInfo::set('dir3', $this->_dir3);
		SiteInfo::set('dir4', $this->_dir4);

		PC_Debug::log("module:" . $this->_module . ', controller:' . $this->_controller . ', method:' . $this->_method, __FILE__, __LINE__);
	}

	function setup_user() {
		if (@$_SESSION['user']) {
			UserInfo::set_data($_SESSION['user']);
		}
	}
    
	function execute() {
		$module = $this->_module;
		$classfile = $this->_controller;
		$classname = $module . '_' . $this->_controller;
		$file = PUMPCMS_APP_PATH . '/module/' . $module . '/controller/' . $classfile . '.php';
		$not_found_class_file = PUMPCMS_APP_PATH . '/module/' . $module . '/controller/notfound.php';

		if (file_exists($file) == false) {
			if  ($module == 'admin') {
				$file = PUMPCMS_APP_PATH . '/module/' . $classfile . '/controller/admin.php';
			}

			if (file_exists($file) == false) {
				PC_Debug::log('debug2', __FILE__, __LINE__);
				$this->set_not_found();
			
				$module = $this->_module;
				$classfile = $this->_controller;
				$classname = $module . '_' . $this->_controller;
				$file = PUMPCMS_APP_PATH . '/module/' . $module . '/controller/' . $classfile . '.php';
			}
		}

		require_once $file;

		if (class_exists($classname) == false) {
			$this->set_not_found();
		}
		
		$class = new $classname();
		$method = $this->_method;
		
		$this->render->module = $module;
		$this->render->class = $classname;
		$this->render->method = $method;
	    
		ob_start();
		$this->render->module_execute();
		$this->render->module_output = ob_get_contents();
		ob_end_clean();
	}

	function set_not_found() {
		$this->_module = 'index';
		$this->_controller = 'notfound';
	}
}
