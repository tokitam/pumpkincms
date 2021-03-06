<?php

class link_index extends PC_Controller {
    var $tag_list = null;

    public function __construct() {

        //PC_Util::redirect_if_not_site_admin();

        $this->_flg_scaffold = true;
        $this->_module = 'link';
        $this->_table = 'link';

        PC_Render::add_javascript('/js/pumpform_select2.js');
        PC_Render::add_javascript('/js/jquery-ui.min.js');
        PC_Render::add_javascript('/js/tag-it/tag-it.min.js');
        PC_Render::add_css('/css/jquery-ui.css');
        PC_Render::add_css('/js/tag-it/jquery.tagit.css');
    }

    public function detail() {
        preg_match('@/([0-9]+)@', $_SERVER['REQUEST_URI'], $r);
        if (isset($r[1])) {
            PC_Config::set('og::url', PC_Config::url() . '/link/' . intval($r[1]));
        }
        parent::detail();
    }

    public function index() {
        if (isset($_GET['tag'])) {
            $db = PC_DBSet::get();
            PumpForm::$where = ' ( tag LIKE ' . $db->escape('%' . $_GET['tag']. '%') . ' ) ';
        }
        if (PC_Config::get('dir1') == '') {
            $tag_ormap = PumpORMAP_Util::get('link', 'tag');
            PC_Config::set('tag_list', $tag_ormap->get_list('', 0, 30, 'count', true));
        }

        parent::index();
    }
}
