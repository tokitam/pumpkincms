<?php

class PC_Controller {
	var $base_url;
	var $form;
    var $title;
    var $_flg_scaffold = false;
    var $_module;
    var $_table;
    var $_data;

	function __construct() {
	}
	
	function render($class='') {
		$class_name = get_class($this);
		$s = explode('_', $class_name);
		$module = $s[0];
		if ($class == '') {
		    $class = $s[1];
		}

		$theme_template = PUMPCMS_PUBLIC_PATH . '/themes/' . PC_Config::get('layout') . '/template/' . $module . '_' . $class . '.php';

		if (is_readable($theme_template)) {
			$file = $theme_template;
		} else {
		    $file = PUMPCMS_APP_PATH . '/module/' . $module . '/view/' . $class . '.php';
		}

	    if (is_readable($file) == false) {
		    die('File not found:' . $file . ' ' . __FILE__ .':' . __LINE__);
		}
		include $file;
	}

    public function index() {
		if ($this->_flg_scaffold) {
		    $this->scaffold($this->_module, $this->_table, 'list');
		}
    }
    
    public function detail() {
		if ($this->_flg_scaffold) {
		    $this->scaffold($this->_module, $this->_table, 'detail');
		}
    }
    
    public function edit() {
		if ($this->_flg_scaffold) {
		    $this->scaffold($this->_module, $this->_table, 'form');
		}
    }
    
    public function add() {
		if ($this->_flg_scaffold) {
		    $this->scaffold($this->_module, $this->_table, 'add');
		}
    }
    
    public function delete() {
		if ($this->_flg_scaffold) {
		    $this->scaffold($this->_module, $this->_table, 'delete');
		}
    }
    
	public function scaffold($module, $table, $file) {
		//PC_Debug::log('PC_Controller::scaffold()', __FILE__, __LINE__);

		PC_Util::include_language_file($module);
		$module_org = $module;
		
		$form_config = PumpFormConfig::get_config($module, $table);
	    
		if (@$form_config['master_admin_only'] && UserInfo::is_master_admin() == false) {
			PC_Util::redirect_top();
		}

		$pump_form = new PumpForm();	
		$this->_data = $pump_form->scaffold($module, $table, $file);
		$this->title = $pump_form->get_title($module, $table);

		if ($file == 'list') {
			if (@$form_config['list_php']) {
				$class = $form_config['list_php'];
			} else {
				$module = 'pumpform';
				$class = $file;
			}
		}
		if ($file == 'form' || $file == 'add' || $file == 'edit') {
			if (@$form_config['form_php']) {
				$class = $form_config['form_php'];
			} else {
				$module = 'pumpform';
				$class = 'form';
			}
		}
		if ($file == 'detail') {
			if (@$form_config['detail_php']) {
				$class = $form_config['detail_php'];
			} else {
				$module = 'pumpform';
				$class = $file;
			}
		}
		if ($file == 'delete') {
			if (@$form_config['detail_php']) {
				$class = $form_config['detail_php'];
			} else {
				$module = 'pumpform';
				$class = $file;
			}
		}

		$theme_template = PUMPCMS_PUBLIC_PATH . '/themes/' . PC_Config::get('layout') . '/template/' . $module_org . '_' . $class . '.php';

		if (is_readable($theme_template)) {
			$file = $theme_template;
		} else {
			$file = PUMPCMS_APP_PATH . '/module/' . $module . '/view/' . $class . '.php';
		}

		if (is_readable($file) == false) {
			die('File not found:' . $file . ' ' . __FILE__ .':' . __LINE__);
		}
		include $file;
	}

	function set_variable() {
		$this->base_url = PC_Config::get('base_url');
	}
}

