<?php

require_once PUMPCMS_SYSTEM_PATH . '/pumpform_define.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpormap.php';
require_once PUMPCMS_SYSTEM_PATH . '/pagenavi.php';

$pumpform_config = array();

class PumpForm {
    var $_flg_loaded_config = false;
    var $data;
    var $error;
    var $form;
    static $target_id = 0;

    static $redirect_url = '';
    static $scaffold_base_url = '';
    static $edit_url = '';
    static $delete_url = '';
    static $add_pre_process = null;
    static $add_post_process = null;
    static $edit_load_process = null;
    static $edit_pre_process = null;
    static $edit_post_process = null;
    static $delete_post_process = null;

    static $call_after_update = null;
    static $pagenavi = null;
    static $where = '';
    static $file = '';
    static $insert_id = 0;

    public function __construct() {

    }

    public function scaffold($module, $table, $file) {
        global $pumpform_config;

        self::$file = $file;

        PC_Util::include_language_file('pumpform');
        PC_Util::include_language_file($module);
        PumpFormConfig::load_config($module);

        $this->auth_check($module, $table);

        if ($file == '' ||
            $file == 'list') {
            return $this->get_list($module, $table);
        } else if ($file == 'detail') {
            return $this->get_detail($module, $table);
        } else if ($file == 'add') {
            return $this->get_add_form($module, $table);
        } else if ($file == 'delete') {
            return $this->get_delete_form($module, $table);
        } else {
            return $this->get_edit_form($module, $table); 
        }
    }

    public function auth_check($module, $table) {
        return;

        global $pumpform_config;
        $form = $pumpform_config[$module][$table];

        if (@$form['1n_link_id']) {
            if (@$_GET[$form['1n_link_id']]) {
                //l ok
            } else {
                PC_Util::redirect_top();
            }
        }
    }

    public function get_list($module, $table, $where='', $offset=null, $limit=null) {
        global $pumpform_config;

        PC_Util::include_language_file('pumpform');
        PC_Util::include_language_file($module);

        //$this->loadFormConfig($module, $table);
        PumpFormConfig::load_config($module);

        $form_config = @$pumpform_config[$module][$table];

        if (@$_GET['offset']) {
            $offset = intval($_GET['offset']);
        } else {
            $offset = 0;
        }

        if (@$_GET['limit']) {
            $limit = intval($_GET['limit']);
        } else if (@$form_config['list_limit']) {
            $limit = intval($form_config['list_limit']);
        } else if ($limit != null) {
            $limit = intval($limit);
        } else {
            $limit = 10;
        }

        if (preg_match('/^([ud])_([_0-9A-Za-z]+)$/', @$_GET['sort'], $r)) {
            $up_down = $r[1];
            $sort = $r[2];
            if ($up_down == 'u') {
                $re_sort = false;
            } else {
                $re_sort = true;
                $up_down = 'd';
            }
        } else if (preg_match('/^([ud])_([_0-9A-Za-z]+)$/', @$form_config['default_sort'], $r)) {
            $up_down = $r[1];
            $sort = $r[2];
            if ($up_down == 'u') {
                $re_sort = false;
            } else {
                $re_sort = true;
                $up_down = 'd';
            }
        } else {
            $sort = null;
            $re_sort = null;
        }

        $ormap = new PumpORMAP($form_config);
        $data = array();

        if (@$form_config['1n_link_id']) {
            if ($where != '') {
                $where .= ' AND ';
            }
            $link_id = preg_replace('/[^0-9A-Za-z_]/', '', $form_config['1n_link_id']);
            $where = ' ' . $link_id . ' = ' . intval($_GET[$link_id]);
        }
        if (@self::$where != '') {
            if ($where != '') {
                $where .= ' AND ';
            }
            $where .= self::$where;
        }

        $data['list'] = $ormap->get_list($where, $offset, $limit, $sort, $re_sort);
        $where = '';
        $option = null;
        if (@$form_config['1n_link_id']) {
            $link_id = preg_replace('/[^0-9A-Za-z_]/', '', $form_config['1n_link_id']);
            $where = ' ' . $link_id . ' = ' . intval($_GET[$link_id]);
            $option = array('link_option' => $link_id . '=' . intval($_GET[$link_id]));
        }

        if (@self::$where != '') {
            if ($where != '') {
                $where .= ' AND ';
            }
            $where .= self::$where;
        }

        $total = $ormap->get_count($where);
        $data['total'] = $total;

        $pagenavi = new PC_PageNavi($total, @$_GET['offset'], $limit, $option);
        $data['pagenavi'] = $pagenavi;

        return $data;
    }

    public function get_add_form($module, $table) {
        global $pumpform_config;

        $form = $pumpform_config[$module][$table]['column'];

        $error = array();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $error = $this->validate($module, $table);

            if (count($error) == 0) {
                if (self::$add_pre_process != null) {
                    $func = self::$add_pre_process;
                    $func();
                }

                $form_config = $pumpform_config[$module][$table];
                $pumpormap = new PumpORMAP($form_config);
                self::$insert_id = $pumpormap->insert();

                if (self::$add_post_process != null) {
                    $func = self::$add_post_process;
                    $func();
                }

                if (self::$redirect_url) {
                    $redirect_url = self::$redirect_url;
                    self::$redirect_url = '';
                } else {
                    $module_url = PC_Util::get_module_url();
                    $redirect_url = $module_url . '/detail/' . self::$insert_id . '/';
                }
                PC_Notification::set(_MD_PUMPFORM_ADDED);
                PC_Util::redirect($redirect_url);
            }
        }

        $this->form = $form;

        $data = array();
        $data['error'] = $error;

        return $data;
    }

    public function get_edit_form($module, $table) {
        global $pumpform_config;

        $form = $pumpform_config[$module][$table]['column'];
        $form_config = $pumpform_config[$module][$table];
        $data = array();
        $error = array();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $error = $this->validate($module, $table);

            if (count($error) == 0) {

                if (self::$edit_pre_process != null) {
                    $func = self::$edit_pre_process;
                    $func();
                }

                $pumpormap = new PumpORMAP($form_config);
                if (self::$target_id) {
                    $target_id = self::$target_id;
                    self::$target_id = 2;
                } else {
                    $target_id = PC_Config::get('dir4');
                }

                if (self::$redirect_url) {
                    $redirect_url = self::$redirect_url;
                    self::$redirect_url = '';
                } else {
                    $module_url = PC_Util::get_module_url();
                    $redirect_url = $module_url . '/detail/' . $target_id . '/';
                }
                $pumpormap->update($target_id);
                if (self::$call_after_update != null) {
                    $func = self::$call_after_update;
                    $func();
                    self::$call_after_update = null;
                }

                if (self::$edit_post_process != null) {
                    $func = self::$edit_post_process;
                    $func();
                }

                PC_Notification::set(_MD_PUMPFORM_UPDATED);
                PC_Util::redirect($redirect_url);
            }
        } else {
            if (self::$target_id) {
                $target_id = self::$target_id;
                self::$target_id = 0;
            } else {
                $target_id = PC_Config::get('dir4');
            }

            if (self::$edit_load_process == null) {
                $ormap = new PumpORMAP($form_config);
                $data['item'] = $ormap->get_one($target_id);
            } else {
                $func = self::$edit_load_process;
                $data['item'] = $func($target_id);
            }
        }

        $this->form = $form;

        $data['error'] = $error;
        return $data;
    }

    public function get_detail($module, $table) {
        global $pumpform_config;

        $form_config = $pumpform_config[$module][$table];

        $ormap = new PumpORMAP($form_config);

        if (self::$target_id) {
            $target_id = self::$target_id;
            self::$target_id = 0;
        } else if (isset($_GET['id'])) {
            $target_id = intval($_GET['id']);
        } else {
            $target_id = PC_Config::get('dir4');
        }
        $item = $ormap->get_one($target_id);
        $form = $pumpform_config[$module][$table]['column'];

        $data = array();
        $data['item'] = $item;

        return $data;
    }

    public function get_delete_form($module, $table) {
        global $pumpform_config;

        $form_config = $pumpform_config[$module][$table];

        $ormap = new PumpORMAP($form_config);
        $form = $pumpform_config[$module][$table]['column'];

        if (self::$target_id) {
            $target_id = self::$target_id;
            self::$target_id = 0;
        } else {
            $target_id = PC_Config::get('dir4');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ormap->delete($target_id);

            if (self::$redirect_url) {
                $redirect_url = self::$redirect_url;
                self::$redirect_url = '';
            } else {
                $module_url = PC_Util::get_module_url();
                $redirect_url = $module_url . '/';
            }

            if (self::$delete_post_process != null) {
                PC_Debug::log(' delete()1 ', __FILE__, __LINE__);
                $func = self::$delete_post_process;
                $func();
            }

            PC_Notification::set(_MD_PUMPFORM_DELETED);
            PC_Util::redirect($redirect_url);
        }

        $item = $ormap->get_one($target_id);
        $data = array();
        $data['item'] = $item;

        return $data;
    }

    public function validate($module, $table) {
        global $pumpform_config;

        PC_Util::include_language_file('pumpform');
        PumpFormConfig::load_config($module);

        $error = array();
        $form = $pumpform_config[$module][$table]['column'];

        if (Csrf_protection::validate() == false) {
            $error['csrf'] = 'CSRF check failure';
        }

        foreach ($form as $column) {
            $data = @$_POST[$column['name']];

            if ($column['type'] == PUMPFORM_IMAGE) {
                if (@$column['required']) {
                    if (@$_FILES[$column['name']]['name'] == '') {
                        $error[$column['name']] = _MD_PUMPFORM_INPUT;
                        continue;
                    }
                }
                if (isset($_FILES[$column['name']]['error']) == false) {
                    continue;   
                }

                if (isset($_FILES[$column['name']]['error']) && 0 < $_FILES[$column['name']]['size']) {
                    if (@$_FILES[$column['name']]['error'] == UPLOAD_ERR_INI_SIZE) {
                        $error[$column['name']] = _MD_PUMPFORM_FILE_SIEZ_ORVER;
                        continue;
                    }
                    if (@$_FILES[$column['name']]['error'] != UPLOAD_ERR_OK) {
                        $error[$column['name']] = _MD_PUMPFORM_UPLOAD_FAILURE . '(1)';
                        continue;
                    }
                }
            } else if ($column['type'] == PUMPFORM_FILE) {
                if (@$column['required']) {
                    if (@$_FILES[$column['name']]['name'] == '') {
                        $error[$column['name']] = _MD_PUMPFORM_INPUT;
                        continue;
                    }
                }
                if (isset($_FILES[$column['name']]['error']) == false) {
                    continue;   
                }

                if (isset($_FILES[$column['name']]['error']) && 0 < $_FILES[$column['name']]['size']) {
                    if (@$_FILES[$column['name']]['error'] == UPLOAD_ERR_INI_SIZE) {
                        $error[$column['name']] = _MD_PUMPFORM_FILE_SIEZ_ORVER;
                        continue;
                    }
                    if (@$_FILES[$column['name']]['error'] != UPLOAD_ERR_OK) {
                        $error[$column['name']] = _MD_PUMPFORM_UPLOAD_FAILURE . '(2)';
                        continue;
                    }
                }
            } else {
                if (@$column['required']) {
                    if ($data == '') {
                        $error[$column['name']] = _MD_PUMPFORM_INPUT;
                        continue;
                    }
                }
            }

            if (@$column['check_overlap'] && @$column['check_overlap']['type'] == 'multi_db') {
                $db = PC_DBSet::get();
                foreach ($column['check_overlap']['dbs'] as $check) {
                    $check_ormap = PumpORMAP_Util::get($check['module'], $check['table']);
                    if (PC_Config::get('dir3') == 'edit') {
                        $where = $check['column'] . ' = ' . $db->escape($data);
                        $where .= ' AND id <> ' . intval(PC_Config::get('dir4'));
                    } else {
                        $where = $check['column'] . ' = ' . $db->escape($data);
                    }
                    $list = $check_ormap->get_list($where);

                    if (! empty($list)) {
                        $error[$column['name']] = _MD_PUMPFORM_OVERLAP_ERROR;
                        continue;
                    }
                }
            }

            if (@$column['minlength'] && mb_strlen($data) < $column['minlength']) {
                $error[$column['name']] = sprintf(_MD_PUMPFORM_NG_LENGTH . '(1)', intval(@$column['minlength']), intval(@$column['maxlength']));
            }
            if (@$column['maxlength'] && $column['maxlength'] < mb_strlen($data)) {
                $error[$column['name']] = sprintf(_MD_PUMPFORM_NG_LENGTH . '(2)', intval(@$column['minlength']), intval(@$column['maxlength']));
            }

            if (@$column['type'] == PUMPFORM_PASSWORD) {
                if (@$_POST[$column['name']] != @$_POST[$column['name'] . '2']) {
                    $error[$column['name']] = _MD_PUMPFORM_PASSWORD_NOT_ACCORD;
                }
            }
        }

        return $error;
    }

    function get_title($module, $table) {
        global $pumpform_config;
        return $pumpform_config[$module][$table]['title'];
    }

    static public function get_target_id() {
        if (self::$target_id) {
            return self::$target_id;
        } else {
            return PC_Config::get('dir4');
        }
    }
}

