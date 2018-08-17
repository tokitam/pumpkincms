<?php

class image_upload extends PC_Controller {
    public function add() {
        $column = 'upload';
        
        if (empty($_FILES[$column]['tmp_name'])) {
            echo json_encode(['error' => 1]);
            exit();
        }

        $pumpimage = new PumpImage();
        $image_id = $pumpimage->upload($column);

        if (empty($image_id)) {
            echo json_encode(['error' => 1]);
            exit();
        }

        $json = [];
        $url = PC_Config::url() . PumpImage::get_image_path($image_id);
        $json['fileName'] = basename($url);
        if (empty($json['fileName'])) {
            $json['fileName'] = 'image_file';
        }
        $json['uploaded'] = 1;
        $json['url'] = $url;
        header('Content-type: application/json');
        echo json_encode($json, JSON_UNESCAPED_SLASHES);
        exit();
    }
}
