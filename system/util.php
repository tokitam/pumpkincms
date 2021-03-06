<?php

require_once PUMPCMS_ROOT_PATH . '/external/OpenGraph.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpmailer.php';

class PC_Util {
    static function redirect($url) {
        header('Location: ' . $url);
        exit();
    }

    static function redirect_top() {
        header('Location: ' . PC_Config::url());
        exit();
    }

    static function redirect_if_not_site_admin($url='') {
        if (UserInfo::is_site_admin() == false) {
            if ($url == '') {
                self::redirect_top();
            } else {
                self::redirect($url);
            }
        }
    }

    static function redirect_if_no_loggedin($url='') {
        if (UserInfo::is_loggedin() == false) {
            if ($url == '') {
                self::redirect_top();
            } else {
                self::redirect($url);
            }
        }
    }

    static function redirect_if_no_login($url='') {
        self::redirect_if_no_loggedin($url);
    }

    static function check_batch() {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            die();
        }
    }

    static function is_email($email) {
        if (preg_match('|^[0-9a-z_./?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$|', $email)) {
            return true;
        } else {
            return false;
        }
    }

    static function is_url($url) {
        if (preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $url)) {
            return true;
        } else {
            return false;
        }
    }

    static function is_domain($domain) {
        if (preg_match('/^[a-z][0-9a-z\.\-]+$/i', $domain)) {
            return true;
        } else {
            return false;
        }
    }

    static function is_twitterid($twitterid) {
        if (preg_match('/^\@([0-9A-Za-z]+)$/', $twitterid, $r)) {
            return true;
        } else {
            return false;
        }
    }

    static function mail($to, $subject, $message) {
        if (PC_Config::get('mail_function') == 'phpmailer') {
            $mailer = new PumpMailer();
            $mailer->send($to, $subject, $message);
            return;
        }

        mb_internal_encoding('UTF-8');

        $subject = self::mail_convert_subject($subject);
        $message = self::mail_convert_body($message);
        $message = mb_convert_encoding($message, 'ISO-2022-JP-MS');

        $headers = 'From: ' . PC_Config::get('from_email') . "\r\n" .
        'Reply-To: ' . PC_Config::get('from_email') . "\r\n" . 
        'Content-Transfer-Encoding: 7bit' . "\r\n" .
        'Content-Type: text/plain; charset="iso-2022-jp"' . "\r\n";

        @mail($to, $subject, $message, $headers);
    }

    static function mail_convert_subject($subject) {
        $subject = preg_replace('/\[site_title\]/', PC_Config::get('site_title'), $subject);
        $subject = preg_replace('/\[base_url\]/', PC_Config::get('base_url'), $subject);
        $subject = mb_encode_mimeheader($subject, 'ISO-2022-JP-MS');
        return $subject;
    }

    static function mail_convert_body($body) {
        $body = preg_replace('/\[site_title\]/', PC_Config::get('site_title'), $body);
        $body = preg_replace('/\[base_url\]/', PC_Config::get('base_url'), $body);
        return $body;
    }

    static function admin_mail($subject, $message) {
        $admin_email = PC_Config::get('admin_email');
        if (empty($admin_email)) {
            return;
        }

        self::mail(PC_Config::get('admin_email'), $subject, $message);
    }

    static function random_code($length, $type=1) {
        if ($type == 1) {
            $str = '0123456789abcdefghijklmnopqrstuvwxyz';
        } else {
            $str = '0123456789ABCDEFGHIJKLNNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        }

        $max = strlen($str);

        $s = '';
        for ($i=0; $i < $length; $i++) {
            $s .= substr($str, rand(0, $max - 1), 1);
        }

        return $s;
    }

    static function include_language_file($module) {
        $lang_file = PUMPCMS_APP_PATH . '/module/' . $module . '/language/' . PC_Config::get('language') . '/main.php';
        $english_file = PUMPCMS_APP_PATH . '/module/' . $module . '/language/english/main.php';
        $extra_lang_file = '';

        if ($module == 'user' && PC_Config::get('extra_user_profile')) {
            $c = PC_Config::get('extra_user_profile');
            $module = $c['module'];
            $extra_lang_file = PUMPCMS_APP_PATH . '/module/' . $module . '/language/' . PC_Config::get('language') . '/extra_main.php';
            if (file_exists($extra_lang_file)) {
                require_once $extra_lang_file;
            }
        }

        if (file_exists($lang_file)) {
            require_once $lang_file;
        } else if (file_exists($english_file)) {
            require_once $english_file;
        }
    }

    static function ref_values($arr){ 
    if (strnatcmp(phpversion(),'5.3') >= 0) //Reference is required for PHP 5.3+ 
    { 
        $refs = array(); 
        foreach($arr as $key => $value) 
            $refs[$key] = &$arr[$key]; 
        return $refs; 
    } 
    return $arr; 
    } 

    static function is_top_page() {
        if (PC_Config::get('service_url') == '') {
            return true;
        }

        return false;
    }

    static function get_ip_address() {
        if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])
            && $_SERVER['HTTP_X_FORWARDED_FOR'] != @$_SERVER['REMOTE_ADDR']) {
            $HTTP_SERVER_VARS['REMOTE_ADDR'] = $REMOTE_ADDR = $_SERVER['REMOTE_ADDR'] = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return @$_SERVER['REMOTE_ADDR'];
    }

    static function get_useragent() {
        return @$_SERVER['HTTP_USER_AGENT'];
    }

    static function get_service_base_path() {
        if (@$_SERVER['REQUEST_URI'] == '' ||
            $_SERVER['REQUEST_URI'] == '/') {
            return '';
        } else if (@$_SERVER['QUERY_STRING'] == '') {
            preg_match('@(.+)/?@', $_SERVER['REQUEST_URI'], $r);
            return self::cut_tail_slash($r[1]);
        } else {
            $q = self::cut_tail_slash($_SERVER['QUERY_STRING']);
            if (strstr($q, '=')) {
                $arr = explode('=', $q);
                $q = $arr[1];
            }

            $req = self::cut_tail_slash($_SERVER['REQUEST_URI']);

            preg_match('@(.+)/' . $q . '$@', $req, $r);
            if (isset($r[1])) {
                return $r[1];
            } else {
                return '';
            }
        }
    }

    static function get_url() {
        return (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . @$_SERVER["HTTP_HOST"] . @$_SERVER["REQUEST_URI"];
    }

    static function cut_tail_slash($s) {
        $l = substr($s, -1, 1);
        if ($l == '/') {
            return substr($s, 0, -1);
        }

        return $s;
    }

    static function strip_tags($str) {
        $tags = array('a', 'p', 'span', 'em', 'iframe', 'img', 'li', 
            'ol', 'br', 'hr',  'script',
            'table', 'tr', 'td', 'th');
        $t = '';
        foreach ($tags as $i) {
            $t .= '<' . $i . '>';
        }
        return strip_tags($str, $t);
    }

    static function split_pagebreak($str) {
        if (preg_match('/^(.+)<!-- pagebreak -->(.+)$/s', $str, $r)) {
            return $r[1];
        } else {
            return $str;
        }
    }

    static function get_module_url() {
        if (PumpForm::$scaffold_base_url != '') {
            $module_url = PumpForm::$scaffold_base_url;
        } else {
            $module_url = PC_Config::url() . '/' . PC_Config::get('dir1');
            if (PC_Config::get('dir2') != '') {
                $module_url .= '/' . PC_Config::get('dir2');
            } else {
                $module_url .= '/index';
            }
        }

        return $module_url;
    }

    static public function is_admin_dir() {
        if (preg_match('@^admin/@', PC_Config::get('service_url'))) {
            return true;
        } else {
            return false;
        }
    }

    static public function is_smartphone() {
        $ua = $_SERVER["HTTP_USER_AGENT"];

        if (strpos($ua, 'Android') != false) {
            if (strpos($ua, 'Mobile') != false) {
                return true;
            }
        } else if (strpos($ua, 'iPhone') != false) {
            return true;
        }

        return false;
    }

    static public function truncate($str, $len=60) {
        return self::mb_truncate($str, $len);
    }

    static public function mb_truncate($str, $len=60) {
        if (mb_strlen($str) <= $len) {
            return $str;
        }

        return mb_substr($str, 0, $len) . '...';
    }

    static function mb_chr($num){
        return ($num < 256) ? chr($num) : mb_chr($num / 256).chr($num % 256);
    }

    static function mb_ord($char){
        return (strlen($char) < 2) ?
        ord($char) : 256 * mb_ord(substr($char, 0, -1)) + ord(substr($char, -1));
    }

    static function mb_trim($string)
    {
        $whitespace = '[\s\0\x0b\p{Zs}\p{Zl}\p{Zp}]';
        $ret = preg_replace(sprintf('/(^%s+|%s+$)/u', $whitespace, $whitespace), '', $string);
        return $ret;
    }

    static function convert_size($size) {
        if ($size < 1024) {
            return $size . 'B';
        }

        if ($size < 1024 * 1024) {
            return (intval(10 * $size / 1024) / 10) . 'KB';
        }

        if ($size < 1024 * 1024 * 1024) {
            return (intval(10 * $size / 1024 / 1024) / 10) . 'MB';
        }

        // over 1TB 
        return (intval(10 * $size / 1024 / 1024 / 1024) / 10) . 'TB';
    }

    static function convert_size_rev($size) {
        if (preg_match('/([0-9]+)([KMT])/i', $size, $r)) {
    // do nothing
        } else {
            return $size;
        }

        if ($r[2] == 'K') {
            return $r[1] * 1024;
        }

        if ($r[2] == 'M') {
            return $r[1] * 1024 * 1024;
        }

        if ($r[2] == 'T') {
            return $r[1] * 1024 * 1024 * 1024;
        }

        return $r[1];
    }

    static function password_hash($password) {
        if (PC_Config::get('password_hash') == 'MD5') {
            return md5($password);
        }

        if (PC_Config::get('password_hash') == 'SHA1') {
            return sha1($password);
        }

        $a = password_hash($password, PASSWORD_BCRYPT);

        return $a;
    }

    static function password_verify($password, $hash) {
        if (PC_Config::get('password_hash') == 'MD5') {
            if (md5($password) == $hash) {
                return true;
            } else {
                return false;
            }
        }

        if (PC_Config::get('password_hash') == 'SHA1') {
            if (sha1($password) == $hash) {
                return true;
            } else {
                return false;
            }
        }

        return password_verify($password, $hash);
    }

    static function get_opengraph($url) {
        $graph = OpenGraph::fetch($url);
        $list = array();

        if (empty($graph)) {
            $ret = self::check_image_url($url);
            if ($ret == false) {
                return $list;
            }
            $list['image_id'] = $ret;
            return $list;
        }

        foreach ($graph as $key => $value) {
            $list[$key] = $value;
        }

        return $list;
    }

    static function check_image_url($url) {
        $buf = file_get_contents($url);

        foreach ($http_response_header as $key => $value) {
            if (preg_match('@Content-Type: (image/.+)@', $value, $r)) {
                $tmpfile = tempnam(sys_get_temp_dir(), 'pump_ex_image');
                file_put_contents($tmpfile, $buf);
                $pumpimage = new PumpImage();
                $image_id = $pumpimage->upload(null, $tmpfile, $r[1]);
                unlink($tmpfile);
                return $image_id;
            }
        }

        return false;
    }

    static public function get_unset_user_image_id() {    
        $list = PC_Config::get('unset_user_image_id_list');
        if (empty($list[0])) {
            return 0;
        }
        shuffle($list);
        return $list[0];
    }

    static public function convert_url2link($text) {
        return mb_ereg_replace('(https?://[-_.!~*\'()a-zA-Z0-9;/?:@&=+$,%#]+)', '<a href="\1" target="_blank">\1</a>', $text);
    }

    static public function in_text_short_url2long_url($text) {
        if (empty($text)) {
            return '';
        }

        if (preg_match_all('/(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/', $text, $r)) {
            foreach ($r[0] as $short_url) {
                $long_url = self::short_url2long_url($short_url);
                $text = str_replace($short_url, $long_url, $text);
            }
        }

        return $text;
    }

    static public function short_url2long_url($short_url) {
        if (empty($short_url)) {
            return '';
        }

        $headers = get_headers($short_url);
        foreach ($headers as $header) {
            if (preg_match('/^location: (.+)$/', $header, $r)) {
                if (isset($r[1])) {
                    return $r[1];
                }
            }
        }

        return $short_url;
    }

    static public function get_uuid_v4() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 65535), mt_rand(0, 65535),
            // 16 bits for "time_mid"
            mt_rand(0, 65535),
            // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
            mt_rand(0, 4095) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535)
            );
    }

    static public function convert_twitter_icon_url($url) {
        if (preg_match('@(.+)_normal\.(jpeg|jpg|png|gif)$@', $url, $r)) {
            return $r[1] . '.' . $r[2];
        }

        return $url;
    }

   /**
     * call curl library
     * @param $url string URL
     * @param $param array URL parameter
     * @param $method string method, GET, POST, DELETE, OPTION
     * @param $option array option parameter
     */
    static public function curl($url, $param=[], $method='GET', $option=[]) {
        if (empty($url) || self::is_url($url) == false) {
            throw new Exception('PC_Util::curl() $url wrong');
        }

        $method = strtoupper($method);

        if ($method != 'GET' && $method != 'POST' && $method != 'DELETE' && $method != 'OPTION') {
            throw new Exception('PC_Util::curl() $method wrong');
        }

        $user_password = @$option['user_password'];

        if (is_array($param)) {
            $param = http_build_query($param);
        }
        if ($method == 'GET') {
            $url .= '?' . $param;
        }

        $curl = curl_init($url);

        if ($method == 'POST') {
            // POST method
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        }
        if (!empty($user_password)) {
            curl_setopt($curl, CURLOPT_USERPWD, $user_password);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if (isset($option['output_request_header']) && $option['output_request_header']) {
            curl_setopt($curl, CURLINFO_HEADER_OUT,true);
        }
        if (isset($option['output_response_header']) && $option['output_response_header']) {
            curl_setopt($curl, CURLOPT_HEADER, true);
        }
        if (isset($option['CURLOPT_CUSTOMREQUEST'])) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $option['CURLOPT_CUSTOMREQUEST']);
        }
        if (isset($option['CURLOPT_SSL_VERIFYPEER'])) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, $option['CURLOPT_SSL_VERIFYPEER']);
        }
        if (isset($option['CURLOPT_SSL_VERIFYHOST'])) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $option['CURLOPT_SSL_VERIFYHOST']);
        }
        $res = curl_exec($curl);
        if (isset($option['output_request_header']) && $option['output_request_header']) {
            $request_header = curl_getinfo($curl, CURLINFO_HEADER_OUT);
            var_dump($request_header);
        }
        curl_close($curl);

        return $res;
    }

    /**
     * HTML sanitize
     * @param $html HTML
     * @param $allow_tag allow tag ex:['br', 'img', 'a']
     */
    public static function html_sanitize($html, $allow_tag = array(), $flg_nsl2br=true) {
        $html = htmlspecialchars($html);

        if (empty($allow_tag)) {
            $allow_tag = array('p', 'img', 'br', 'a', 'ol', 'li', 'ul', 'h1', 'h2', 'h3', 'b',
                'strong', 'em', 'pre', 'span', 'blockquote', 'table', 'tbody', 'tr', 'td');
        }

        foreach($allow_tag as $tag) {
            $html = preg_replace_callback("/(\&lt\;$tag\&gt\;)/i", 'PC_Util::unhtmlescape', $html);
            $html = preg_replace_callback("/(\&lt\;$tag .*?\&gt\;)/i", 'PC_Util::unhtmlescape', $html);
            $html = preg_replace_callback("/(\&lt\;\/$tag\&gt\;)/i", 'PC_Util::unhtmlescape', $html);
        }   
        $html = str_replace('&amp;nbsp;', '&nbsp;', $html);
        if ($flg_nsl2br) {
            $html = nl2br($html);
        }
        return $html;
    }

    public static function unhtmlescape($value) {
  
        $text = $value[0];
        
        $text = str_replace('&lt;', '<', $text);
        $text = str_replace('&gt;', '>', $text);
        $text = str_replace('&quot;', '"', $text);

        return $text;
    }
}
