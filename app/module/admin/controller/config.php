<?php

class admin_config extends PC_Controller {
    public function __construct() {

        PC_Util::redirect_if_not_site_admin();

        $this->_flg_scaffold = true;
        $this->_module = 'admin';
        $this->_table = 'config_form';

        PumpForm::$add_pre_process = function() {
        };

        PumpForm::$edit_pre_process = function() {
            function update_or_insert($name, $value) {
                $_POST['name'] = $name;
                $_POST['value'] = $value;
                $db = PC_Dbset::get();
                $ormap = PumpORMAP_Util::get('system', 'config');
                $ormap->update(null, "name = " . $db->escape($name));

                if ($ormap->row_count() == 0) {
                    $ormap->insert($_POST);
                }
            }

            $data = $_POST;
            $list = array(
                'site_title',
                'description',
                'keywords',
                'debug_mode',
                'site_close',
                'site_close_message',
                'allow_register',
                'bg_image_url',
                );
            if (SiteInfo::get_site_id() == 1) {
                array_push($list, 'flg_multi_site', 'multi_site_type');
            }
            foreach ($list as $value) {
                update_or_insert($value, $data[$value]);
            }
            PC_Notification::set(_MD_PUMPFORM_UPDATED);

            PC_Util::redirect(PC_Config::url() . '/admin/config/');
        };

        PumpForm::$edit_load_process = function($target_id) {
            $ormap = PumpORMAP_Util::get('system', 'config');
            $list = $ormap->get_list('site_id = ' . intval(PC_Config::get('site_id')));

            $tmp = array();
            foreach ($list as $key => $value) {
                $tmp[$value['name']] = $value['value'];
            }
            return $tmp;
        };
    }

    public function index() {
        if (SiteInfo::get_site_id() != 1) {
            PumpFormConfig::load_config('admin');
            global $pumpform_config;
            unset($pumpform_config['admin']['config_form']['column']['flg_multi_site']);
            unset($pumpform_config['admin']['config_form']['column']['multi_site_type']);
        }

        self::edit();
    }
}
