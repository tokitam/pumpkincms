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
        $this->check_lang();
        $this->check_site();
        $this->load_config();
        $this->session_config();
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
        PC_Config::load_module_config();
    }

    function session_config() {
        if (PC_Config::get('session_handler') == 'redis') {
            require_once PUMPCMS_SYSTEM_PATH . '/session_redis.php';

            $handler = new Session_Redis_Handler(
                PC_Config::get('redis_host'),   // host
                PC_Config::get('redis_port'),   // port
                '',            // password
                2.0,           // Redis timeout (sec)
                'SESS_REDIS:', // prefix
                PC_Config::get('cookie_lifetime')    // expire time (sec)
            );

            session_set_save_handler(
                array( $handler, 'open' ),
                array( $handler, 'close' ),
                array( $handler, 'read' ),
                array( $handler, 'write' ),
                array( $handler, 'destroy' ),
                array( $handler, 'gc' )
                );
            register_shutdown_function( 'session_write_close' );
        }
		
		if (0 < PC_Config::get('session.cookie_lifetime')) {
			ini_set('session.cookie_lifetime', PC_Config::get('session.cookie_lifetime'));
		}
		if (0 < PC_Config::get('session.gc_maxlifetime')) {
			ini_set('session.gc_maxlifetime', PC_Config::get('session.gc_maxlifetime'));
		}
		
		ini_set('display_errors', true);
		error_reporting(E_ALL);

        session_start();
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

        if (preg_match('@^(.+)\?(.*)$@', $_SERVER['REQUEST_URI'], $r)) {
            $request_uri = @$r[1];
        } else {
            $request_uri = $_SERVER['REQUEST_URI'];
        }

        $base_path = SiteInfo::get_path();

        preg_match('@(' . $base_path . ')(.*)@', $request_uri, $r);
        $service_url = @$r[2];
        PC_Config::set('service_url', $service_url);

        if ($this->site_close()) {
            return;
        }

        $ret = $this->admin_menu_check($service_url);

        if (!$ret) {
            $ret = $this->load_router($service_url);
        }

        $this->set_dir($service_url);

        if (!empty($ret)) {
            $this->_module = $ret['module'];
            $this->_controller = $ret['controller'];
            $this->_method = $ret['method'];
            $theme = @$ret['theme'];
            if ($theme != '') {
                PC_Config::set('theme', $theme);
            }

            return;
        }

        PC_Debug::log("module:" . $this->_module . ', controller:' . $this->_controller . ', method:' . $this->_method, __FILE__, __LINE__);
    }

    function admin_menu_check($service_url) {
        global $module_config;

        if (preg_match('@admin/([_0-9A-Za-z]+)@', $service_url, $r) == false) {
            return false;
        }

        $dir_name = $r[1];

        $ret = null;
        foreach ($module_config as $c) {
            if (isset($c['admin_menu'][$dir_name])) {
                $ret = $c['admin_menu'][$dir_name]; 
            }
        }

        return $ret;
    }

    function load_router($service_url) {
        $router_no = PC_Config::get('router_no');
        $router_list = PC_Config::get('router', $router_no);

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

        return $ret;
    }

    function setup_user() {
        if (@$_SESSION['user']) {
            UserInfo::set_data($_SESSION['user']);
        }
    }

    function site_close() {
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
                return true;
            }

            return false;
        }
    }

    function set_dir($service_url) {
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
