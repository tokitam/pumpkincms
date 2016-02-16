<?php

require_once PUMPCMS_ROOT_PATH . '/external/facebook-php-sdk/facebook.php';
require_once PUMPCMS_APP_PATH . '/module/user/plugin/facebook/oauth_facebook_model.php';

class OAuth_facebook {
	const ACCESS_TOKEN_URL = 'https://api.twitter.com/oauth/access_token';

	public function get_tag() {
		$url = PC_Config::url() . '/user/oauth?type=facebook';
		$code = sprintf("location.href = '%s';", $url);
		$tag = sprintf('<button class="btn btn-default" onclick="%s">facebook認証</button>', $code);

		return $tag;
	}

	public function get() {

		$config = array(
			'appId'  => PC_Config::get('facebook_app_id'),
			'secret' => PC_Config::get('facebook_app_secret')
		);
		$facebook = new Facebook($config);

		if ($facebook->getUser()) {
			$callback = PC_Config::url() . '/user/oauth/callback?type=facebook';
			PC_Util::redirect($callback);
		}

		$url = $facebook->getLoginUrl();

	    header('Location: ' . $url);
	}

	public function callback() {
		$config = array(
			'appId'  => PC_Config::get('facebook_app_id'),
			'secret' => PC_Config::get('facebook_app_secret')
		);
		$facebook = new Facebook($config);
	}

	public function register($user_id) {
		$config = array(
			'appId'  => PC_Config::get('facebook_app_id'),
			'secret' => PC_Config::get('facebook_app_secret')
		);
		$facebook = new Facebook($config);

		if ($facebook->getUser()) {
			try {
				$user = $facebook->api('/me','GET');
			} catch(FacebookApiException $e) {
				throw new Exception('facebook no logind');
			}
		}

		$oauth_facebook_model = new OAuth_facebook_Model();
		$oauth_facebook_model->register($user_id, 
			$user['facebook_id'], 
			$user['email'], 
			$user['name'], 
			$user['link']);
	}

	public function get_user() {
		$config = array(
			'appId'  => PC_Config::get('facebook_app_id'),
			'secret' => PC_Config::get('facebook_app_secret')
		);
		$facebook = new Facebook($config);
		
		if ($facebook->getUser()) {
			try {
				$user = $facebook->api('/me','GET');
			} catch(FacebookApiException $e) {
				throw new Exception('facebook no logind');
			}
		}

		if (empty($user['id'])) {
			return false;
		}

		$oauth_facebook_model = new OAuth_facebook_Model();
		return $oauth_facebook_model->get_user($user['id']);
	}

	public function login($facebook_user) {
		$oauth_facebook_model = new OAuth_facebook_Model();
		$oauth_facebook_model->login($facebook_user['user_id']);
	}
}
