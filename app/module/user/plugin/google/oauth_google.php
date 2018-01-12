<?php

require_once PUMPCMS_APP_PATH . '/module/user/plugin/google/oauth_google_model.php';

class OAuth_google {
    private function get_callback_url() {
        return PC_Config::url() . '/user/oauth/callback?type=google';
    }

    public function get_tag() {
        $querys = array(
                        'client_id' => PC_Config::get('google_client_id'),
                        'redirect_uri' => $this->get_callback_url(),
                        'scope' => 'https://www.googleapis.com/auth/userinfo.email',
                        'response_type' => 'code',
                        );

        $url = 'https://accounts.google.com/o/oauth2/auth?' . http_build_query($querys);
        $code = sprintf("location.href = '%s';", $url);
        $tag = sprintf('<button class="btn btn-default" onclick="%s">google認証</button>', $code);

        return $tag;
    }

    public function callback() {
        $code = $_GET['code'];
        if (empty($code)) {
            throw new Exception('Code not found.');
        }

        $baseURL = 'https://accounts.google.com/o/oauth2/token';
        $params = array(
                        'code'          => $code,
                        'client_id'     => PC_Config::get('google_client_id'),
                        'client_secret' => PC_Config::get('google_client_secret'),
                        'redirect_uri'  => $this->get_callback_url(),
                        'grant_type'    => 'authorization_code'
                        );
        $headers = array(
                         'Content-Type: application/x-www-form-urlencoded',
                         );

        $options = array('http' => array(
                                         'method' => 'POST',
                                         'content' => http_build_query($params),
                                         'header' => implode("\r\n", $headers),
                                         ));

        $response = json_decode(file_get_contents($baseURL, false, stream_context_create($options)));
        $response = (array)$response;

        $user_info = $this->get_google_user_info($response['access_token']);
        $user_info = (array)$user_info;
        $user_info['google_id'] = $user_info['id'];
        $param = array_merge($response, $user_info);

        $_SESSION['google_param'] = http_build_query($param);
        parse_str($_SESSION['google_param'], $param);

        if(empty($response) || isset($response->error)){
            throw new Exception('Invalid response');
        }
    }

    private function get_google_user_info($asscess_token) {
        if (empty($asscess_token)) {
            throw new Exception('Invalid access token');
        }

        $user_info = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo?'.
                                                  'access_token=' . $asscess_token)
                                );

        if (empty($user_info)) {
            throw new Exception('Invalid response oauth2/v1/userinfo');
        }

        return $user_info;
    }

    public function register($user_id) {
        if (empty($_SESSION['google_param'])) {
            throw new Exception('Invalid access: oauth twitter token');
        }

        parse_str($_SESSION['google_param'], $param);
        $oauth_google_model = new OAuth_google_Model();
        $oauth_google_model->register($user_id, 
                                      $param['google_id'],
                                      $param['access_token'], 
                                      $param['name'],
                                      $param['given_name'],
                                      $param['family_name'],
                                      $param['link'],
                                      $param['picture'],
                                      $param['gender']
        );
    }

    public function get_user() {
        parse_str($_SESSION['google_param'], $param);
        $google_id = @$param['id'];

        if (empty($google_id) || !is_numeric($google_id)) {
            throw new Exception('google_id is invalid');
        }

        $oauth_google_model = new OAuth_google_Model();
        return $oauth_google_model->get_user($google_id);
    }

    public function get_name() {
        parse_str($_SESSION['google_param'], $param);
        return $param['name'];
    }

    public function get_email() {
        parse_str($_SESSION['google_param'], $param);
        return $param['email'];
    }

    public function get_icon_url($sns_user) {
        parse_str($_SESSION['google_param'], $param);
        return $param['picture'];
    }

    public function login($google_user) {
        $oauth_google_model = new OAuth_google_Model();
        $oauth_google_model->login($google_user['user_id']);
    }

    public function finish() {
        unset($_SESSION['google_param']);
    }
}
