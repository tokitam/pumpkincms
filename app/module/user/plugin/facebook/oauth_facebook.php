<?php

require_once PUMPCMS_ROOT_PATH . '/external/facebook-php-sdk/facebook.php';
require_once PUMPCMS_APP_PATH . '/module/user/plugin/facebook/oauth_facebook_model.php';

class OAuth_facebook {
    const ACCESS_TOKEN_URL = 'https://api.twitter.com/oauth/access_token';
    public $input_email = false;
    public $input_password = false;
    private $facebook_user;
    private $me = null;

    public function get_tag() {
        $url = PC_Config::url() . '/user/oauth?type=facebook';
        $code = sprintf("location.href = '%s';", $url);
        if (PC_Config::get('facebook_sign_in_button')) {
            $button_image = PC_Config::url() . '/theme/sesxion/image/sign_in_facebook.png';
            $tag = sprintf('<input type="image" src="%s" onclick="%s" />', $button_image, $code);
        } else {
            $tag = sprintf('<button class="btn btn-default" onclick="%s">facebook認証</button>', $code);            
        }

        return $tag;
    }

    public function get() {

        $config = array(
            'appId'  => PC_Config::get('facebook_app_id'),
            'secret' => PC_Config::get('facebook_app_secret')
        );
        $facebook = new Facebook($config);

        if ($facebook->getUser()) {
            $callback = $this->get_callback_url();
            PC_Util::redirect($callback);
        }

		$params['currentUrl'] = $this->get_callback_url();
		//$params = [];
        $url = $facebook->getLoginUrl($params);

        header('Location: ' . $url);
    }
	
	public function get_callback_url() {
		return PC_Config::url() . '/user/oauth/callback?type=facebook';
	}

    public function callback() {
        $config = array(
            'appId'  => PC_Config::get('facebook_app_id'),
            'secret' => PC_Config::get('facebook_app_secret')
        );
        $facebook = new Facebook($config);
    }

    public function get_user_raw() {
        if (! empty($this->user)) {
            return $this->user;
        }

        $config = array(
            'appId'  => PC_Config::get('facebook_app_id'),
            'secret' => PC_Config::get('facebook_app_secret')
        );
        $facebook = new Facebook($config);

        if ($facebook->getUser()) {
            try {
                $this->user = $facebook->api('/me','GET');
            } catch(FacebookApiException $e) {
                throw new Exception('facebook no logind');
            }
        } else {
            throw new Exception('facebook no logind');
		}

        return $this->user;
    }

    public function get_email() {
        return empty($this->user['email']) ? '' : $this->user['email'];
    }

    public function getMe() {
        if (!empty($this->me)) {
            return $this->me;
        }

        $params = array(
            'client_id' => PC_Config::get('facebook_app_id'),
            'client_secret' => PC_Config::get('facebook_app_secret'),
            'code' => $_GET['code'],
            'redirect_uri' => $this->get_callback_url(),
            );

        $url = 'https://graph.facebook.com/oauth/access_token?' . http_build_query($params);
        $body = file_get_contents($url);
        $r = json_decode($body);
        $url = 'https://graph.facebook.com/me?access_token=' . $r->access_token . '&fields=name,picture,email';
        $this->me = json_decode(file_get_contents($url), true); //jsonで返ってくるのでデコード        

        return $this->me;
    }

    public function register($user_id) {
		if (!empty($_GET['code'])) {
            $this->getMe();

            $oauth_facebook_model = new OAuth_facebook_Model();
            $this->facebook_user = $oauth_facebook_model->get_user($this->me['id']);
			if (!empty($this->facebook_user)) {
				$this->user = $this->facebook_user;
				return;
			}
            $oauth_facebook_model->register(
                $user_id, 
                $this->me['id'],
                '', // email
                $this->me['name'],
                '', // url
				$this->me['picture']['data']['url']
                );
            $this->user = $oauth_facebook_model->get_user($this->me['id']);
            //$oauth_facebook_model = new OAuth_facebook_Model();
			//$this->user = $oauth_facebook_model->get_user($me['id']);
			return;
		}
		
        //$this->get_user_raw();

        $oauth_facebook_model = new OAuth_facebook_Model();
        $oauth_facebook_model->register(
            $user_id, 
            $this->user['id'],
            $this->user['email'], 
            $this->user['name'], 
            $this->user['link']);
    }

    public function get_user() {
		if (!empty($this->facebook_user)) {
			return $this->facebook_user;
		}

        $this->getMe();

        $oauth_facebook_model = new OAuth_facebook_Model();
        return $oauth_facebook_model->get_user($this->me['id']);
    }

    public function get_name() {
        $this->getMe();

        if (!empty($this->me)) {
            return $this->me['name'];
        }

		if (empty($this->user) || empty($this->user['name'])) {
			return null;
		}
        return $this->user['name'];
    }

    public function login($facebook_user) {
        $oauth_facebook_model = new OAuth_facebook_Model();
        $oauth_facebook_model->login($facebook_user['user_id']);
    }
	
	public function get_icon_url() {
        //return $this->user->picgture->data->url;
		return '';
	}
}
