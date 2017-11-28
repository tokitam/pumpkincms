<?php

class loadjs_index extends PC_Controller {
    public function __constructor() {
    }

    public function index() {
        if (empty($_GET['module']) || empty($_GET['file'])) {
            exit();
        }

        header('Content-type: text/javascript; charset: UTF-8');

        $module = $_GET['module'];
        $file = $_GET['file'];
        $module = preg_replace('@[^0-9A-Za-z\-._]@', '', $module);
        $file = preg_replace('@[^0-9A-Za-z\-._]@', '', $file);
        $path = PUMPCMS_APP_PATH . '/module/' . $module . '/js/' . $file;

        if (is_readable($path)) {
            readfile($path);
        }
        exit();
    }
}
