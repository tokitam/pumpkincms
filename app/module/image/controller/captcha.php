<?php

require_once PUMPCMS_ROOT_PATH . '/system/pumpcaptcha.php';

class image_captcha extends PC_Controller {
    public function __construct() {
    	$pumpcaptcha = new PumpCaptcha(PUMPCMS_ROOT_PATH . '/resource/Existence-Light.otf');
		$pumpcaptcha->output_image();
		exit();
    }
}
