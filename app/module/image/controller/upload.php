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
        $json['fileName'] = $_FILES[$column]['tmp_name'];
        if (empty($json['fileName'])) {
            $json['fileName'] = 'image_file';
        }
        $json['uploaded'] = 1;
        $json['url'] = PumpImage::get_image_url($image_id);
        header('Content-type: application/json');
        echo json_encode($json);
        exit();
    }
}
