<?php

class PC_Grant {
    static public function check($module, $table, $grant, $post_user_id=0) {
	if (UserInfo::is_site_admin()) {
	    return true;
	}
	
        $form = PumpFormConfig::get_config($module, $table);
	
	if (UserInfo::is_logined()) {
	    if (is_numeric($post_user_id) && 0 < $post_user_id) {
		if (@$form[$grant]['posted_user'] && $post_user_id == UserInfo::get_id()) {
		    return true;
		}
	    }
	    if (isset($form[$grant]['registered_user']) == false) {
		return true;
	    }
	    if (@$form[$grant]['registered_user']) {
		return true;
	    }
	    return false;
	} else {
	    if (isset($form[$grant]['anonymous']) == false) {
		return true;
	    }
	    if (@$form[$grant]['anonymous']) {
		return true;
	    }
	    return false;
	}
	
	return false;
    }
}
