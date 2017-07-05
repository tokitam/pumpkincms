<?php
class PC_Abort {
    public static function abort($message='') {
        $error_message = '<h1>Now maintenance...</h1>';
        $template_file = PUMPCMS_PUBLIC_PATH . '/theme/default/theme.php';
        include $template_file;

        if (UserInfo::is_master_admin()) {
            echo "<hr />\n";
            echo $message . "<br />\n";
            echo "<hr />\n";
            var_dump(debug_backtrace());
        }
        exit();
    }

    public static function error($message, $file='', $line='') {
        die('die ' . $message . ', file:' . $file . ', line:' . $line);
    }

}

