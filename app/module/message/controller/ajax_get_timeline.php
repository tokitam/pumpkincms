<?php

class message_ajax_get_timeline extends PC_Controller {
    function index() {
        $messages = Message_Util::get_message_by_message_id(@$_POST['messageid']);
        $html = '';
        foreach ($messages as $message) {
            $html .= sprintf('<img src="%s" class="img-circle" />', UserInfo::get_icon_url($message['from_user_id']));
        }
        echo $html;
        exit();
    }
}
