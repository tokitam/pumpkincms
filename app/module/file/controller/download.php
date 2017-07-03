<?php

class file_download extends PC_Controller {
    public function __construct() {
    }

    public function index() {
        $ormap = PumpORMAP_Util::get('file', 'file');

        if (isset($_GET['id']) == false) {
            exit();
        }
        if (is_numeric($_GET['id']) == false) {
            exit();
        }

        $file = $ormap->get($_GET['id']);

        if (isset($file['id']) == false) {
            exit();
        }

        $pumpfile = new PumpFIle();
        $file_path = $pumpfile->get_download_path($_GET['id']);
        $size = filesize($file_path);

        header('Content-Disposition: inline; filename="' . ($file['filename']) . '"');
        header('Content-Length: ' . $size);
        header('Content-Type: application/octet-stream');

        if (!readfile($file_path)) {
            die("Cannot read the file(".$file_path.")");
        }

        $pumpfile->post_process();

        exit();
    }
}
