<?php

class PC_Render {
    public $module = '';
    public $class = '';
    public $method = '';
    public $module_output;
    public static $module_output_static;
    static $_javascript_list = array();
    static $_css_list = array();

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

            if (method_exists($obj, $method) == false && 
                method_exists($obj, '__call') == false) {
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
            include PUMPCMS_PUBLIC_PATH . '/theme/admin/theme.php';
        } else {
            ob_start();
            $file1 = PUMPCMS_PUBLIC_PATH . '/wptheme/'  . PC_Config::get('theme') . '/index.php';
            $file2 = PUMPCMS_PUBLIC_PATH . '/theme/'  . PC_Config::get('theme') . '/theme.php';
            if (is_readable($file1)) {
                $GLOBALS['wp_version'] = '2.0';
                $GLOBALS['pagenow'] = '';
                $function_file = PUMPCMS_PUBLIC_PATH . '/wptheme/'  . PC_Config::get('theme') . '/functions.php';
                if (is_readable($function_file)) {
                    include $function_file;
                }
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

    public static function add_javascript($file, $scheme=null) {
        if ($scheme !== null) {
            array_push(self::$_javascript_list, array('path' => $file, 'scheme' => $scheme));
            return;
        }

        array_push(self::$_javascript_list, $file);
    }

    public static function add_css($file) {
        array_push(self::$_css_list, $file);
    }

    public function get_header() {
        $html = '';

        foreach (self::$_javascript_list as $file) {
            if (is_array($file)) {
                if ($file['scheme']) {
                    $html .= sprintf('<script src="%s%s"></script>' . "\n", PC_Config::url(), $file['path']);
                } else {
                    $html .= sprintf('<script src="%s"></script>' . "\n", $file['path']);
                }
            } else if (preg_match('/http/', $file)) {
                $html .= sprintf('<script src="%s"></script>' . "\n", $file);
            } else {
                $html .= sprintf('<script src="%s%s"></script>' . "\n", PC_Config::url(), $file);
            }
        }

        foreach (self::$_css_list as $file) {
            if (preg_match('/http/', $file)) {
                $html .= sprintf('<link href="%s" rel="stylesheet">' . "\n", $file);
            } else {
                $html .= sprintf('<link href="%s%s" rel="stylesheet">' . "\n", PC_Config::url(), $file);
            }
        }

        return $html;
    }
}

