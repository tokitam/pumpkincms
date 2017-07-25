<?php

class image_t extends PC_Controller {
    public function __construct() {
    }

    public function index() {
		if (empty($_GET['i'])) {
			exit();
		}
		
		$i = file_get_contents($_GET['i']);
		header('Content-type: image/jpeg');
		echo $i;
		exit();
    }
}

