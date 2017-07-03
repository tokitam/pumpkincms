<?php

require_once PUMPCMS_SYSTEM_PATH . '/pumpimage.php';

class image_i extends PC_Controller {
    public function __construct() {
    }

    public function __call($name, $args) {
        $pumpimage = new PumpImage();
        $pumpimage->display_image($name);
    }
}

