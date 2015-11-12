<?php

class image_captcha extends PC_Controller {
    public function __construct() {
    	include PUMPCMS_SYSTEM_PATH . '/pumpcaptcha.php';
    }
}
