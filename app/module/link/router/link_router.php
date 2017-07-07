<?php

class link_router {
    static function router($service_url) {
        if (preg_match('@^link/([0-9]+)@', $service_url, $r)) {
	    PumpForm::$target_id = intval($r[1]);
            return array(
                'module' => 'link',
                 'controller' => 'index', 
                 'method' => 'detail');
	}
    }
}
