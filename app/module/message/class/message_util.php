<?php

class Message_Util {
    static $count = null;

    static function get_notification_count($flg_browsed=false) {
        if (UserInfo::is_loggedin() == false) {
            return 0;
        }

        if (self::$count !== null) {
            return self::$count;
        }

        $message_ormap = PumpORMAP_Util::get('message', 'message');

        $where = 'to_user_id = ' . UserInfo::get_id();
        if ($flg_browsed == false) {
            $where .= ' AND browsed = 0';
        }
        $message = $message_ormap->get_list($where);

        if (empty($message)) {
            return '';
        }

        return count($message);
    }

    static function get_message($flg_browsed=false) {
        if (UserInfo::is_loggedin() == false) {
            return [];
        }

        if (self::$count !== null && self::$count == 0) {
            return [];
        }

        $message_ormap = PumpORMAP_Util::get('message', 'message');

        $where = 'to_user_id = ' . UserInfo::get_id();
        if ($flg_browsed == false) {
            $where .= ' AND browsed = 0';
        }
        $message = $message_ormap->get_list($where, 0, 10, 'id', true);

        if (empty($message)) {
            return [];
        }

        return $message;
    }

    /**
     * message_id のメッセージの from_user_id, to_user_id をみてメッセージを返す
     */
    static function get_message_by_message_id($message_id) {
        if (UserInfo::is_loggedin() == false) {
            return false;
        }

        $message_ormap = PumpORMAP_Util::get('message', 'message');
        $message = $message_ormap->get($message_id);
        if (empty($message)) {
            return false;
        }

        if ($message['from_user_id'] == UserInfo::get_id()) {
            $target_user_id = $message['to_user_id'];
        } else {
            $target_user_id = $message['from_user_id'];
        }

        $where = sprintf(' ( from_user_id = %d AND to_user_id = %d ) OR (from_uesr_id = %d AND to_uesr_id = %d )',
                          $target_user_id, UserInfo::get_id(),
                          UserInfo::get_id(), $target_user_id);
        return $message_ormap::get_list($where, 0, 10, 'id', true);
    }
}
