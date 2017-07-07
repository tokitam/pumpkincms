<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';
require_once PUMPCMS_SYSTEM_PATH. '/version.php';

class admin_display_config extends PC_Controller {
    public function index() {
        global $pc_config;
		
		$ini_param =
		  ['session.cookie_lifetime',
		   'session.gc_maxlifetime',
		   'session.save_path',
		   'session.save_handler',
		   'post_max_size',
		   'upload_max_filesize',
		   'memory_limit',
		   ];

        echo '<legend>' . _MD_ADMIN_DISPLAY_CONFIG . '</legend>';

        $i = 0;
        echo '<table class="table table-striped table-hover">';
        echo '<tbody>';
		echo '<tr><td style="background-color: #ddeeff;" colspan="2">system init parameter</td></tr>';
		foreach ($ini_param as $p) {
            if ($i++ % 1) {
                echo '<tr>';
                echo '<td>';
            } else {
                echo '<tr class="odd">';
                echo '<td class="odd">';
            }
			echo $p;
			echo '<td>' . ini_get($p) . '</td>';
            echo '</td>';
            echo '</tr>';
		}
		echo '<tr><td style="background-color: #ddeeff;" colspan="2">config parameter</td></tr>';
        foreach ($pc_config as $key => $config) {
            if ($i++ % 1) {
                echo '<tr>';
                echo '<td>';
            } else {
                echo '<tr class="odd">';
                echo '<td class="odd">';
            }
            echo $key;
            echo '</td>';
            echo '<td>';
            if (is_array($config)) {
                print_r($config);
            } else {
                echo $config;
            }
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }
}

