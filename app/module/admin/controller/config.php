<?php

class admin_config extends PC_Controller {
    public function __construct() {

		if (UserInfo::is_site_admin() == false) {
			PC_Util::redirect_top();
		}

		$this->_flg_scaffold = true;
		$this->_module = 'admin';
		$this->_table = 'config_form';

		PumpForm::$add_pre_process = function() {
			echo ' OK ';
			exit();
		};

		PumpForm::$edit_pre_process = function() {
			function update_or_insert($name, $value) {
				$_POST['name'] = $name;
				$_POST['value'] = $value;
				$db = PC_Dbset::get();
				$ormap = PumpORMAP_Util::get('admin', 'config');
				$ormap->update(null, "name = " . $db->escape($name));

				if ($ormap->row_count() == 0) {
					$ormap->insert($_POST);
				}
			}

			$data = $_POST;
			$list = array(
				'site_title',
				'description',
				'debag_mode',
				'site_close'
			);
			foreach ($list as $value) {
				update_or_insert($value, $data[$value]);
			}
			PC_Notification::set(_MD_PUMPFORM_UPDATED);

			PC_Util::redirect(PC_Config::url() . '/admin/config/');
		};

		PumpForm::$edit_load_process = function($target_id) {
			$ormap = PumpORMAP_Util::get('admin', 'config');
			$list = $ormap->get_list('site_id = ' . intval(PC_Config::get('site_id')));

			$tmp = array();
			foreach ($list as $key => $value) {
				$tmp[$value['name']] = $value['value'];
			}
			return $tmp;
		};
    }

    public function index() {
    	self::edit();
    }
}
