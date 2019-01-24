<?php

class message_ajax_get_modal extends PC_Controller {
    function index() {
        //$this->render('message_ajax_get_modal');
        //$message_id = $_GET['messageid'];
        $ormap = PumpORMAP_Util::get('message', 'message');
        //$where = ' '
        $ormap->get_list();
        include PUMPCMS_APP_PATH . '/module/message/view/message_ajax_get_modal.php';
        exit();
    }
}

