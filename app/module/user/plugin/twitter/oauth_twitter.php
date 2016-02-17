<?php

require_once PUMPCMS_ROOT_PATH . '/external/twitteroauth.php';
require_once PUMPCMS_APP_PATH . '/module/user/plugin/twitter/oauth_twitter_model.php';

class OAuth_twitter {
	const ACCESS_TOKEN_URL = 'https://api.twitter.com/oauth/access_token';
	public $input_email = true;
	public $input_password = false;

	public function get_tag() {
		$url = PC_Config::url() . '/user/oauth?type=twitter';
		$code = sprintf("location.href = '%s';", $url);
		$tag = sprintf('<button class="btn btn-default" onclick="%s">twitter認証</button>', $code);

		return $tag;
	}

	public function get() {

		$consumer_key = PC_Config::get('twitter_consumer_key');
		$consumer_secret = PC_Config::get('twitter_consumer_secret');
		$callback = PC_Config::url() . '/user/oauth/callback?type=twitter';

	    $_SESSION['consumer_key'] = $consumer_key;
	    $_SESSION['consumer_secret'] = $consumer_secret;

		$connection = new TwitterOAuth($_SESSION['consumer_key'], $_SESSION['consumer_secret']);
	    $request_token = $connection->getRequestToken($callback);
	    $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
	    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

	    $url = $connection->getAuthorizeURL($token, false);

	    header('Location: ' . $url);
	}

	public function callback() {
		$request_token = array();
		$request_token['oauth_token'] = $_SESSION['oauth_token'];
		$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

		if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
 		   die( 'Error!' );
		}

		$consumer_key = PC_Config::get('twitter_consumer_key');
		$consumer_secret = PC_Config::get('twitter_consumer_secret');

		$connection = new TwitterOAuth($consumer_key, $consumer_secret, 
			$request_token['oauth_token'], $request_token['oauth_token_secret']);
		$_SESSION['access_token'] = $connection->oAuthRequest(self::ACCESS_TOKEN_URL, 'GET', array('oauth_verifier' => $_REQUEST['oauth_verifier']));
	}

	public function register($user_id) {
		if (empty($_SESSION['access_token'])) {
			throw new Exception('Invalid access: oauth twitter token');
		}

		parse_str($_SESSION['access_token'], $param);
		$oauth_twitter_model = new OAuth_twitter_Model();
		$oauth_twitter_model->register($user_id, 
			$param['oauth_token'], 
			$param['oauth_token_secret'], 
			$param['user_id'], 
			$param['screen_name']);
	}

	public function get_user() {
		parse_str($_SESSION['access_token'], $param);
		$twitter_id = @$param['user_id'];
		
		if (empty($twitter_id)) {
			return false;
		}

		$oauth_twitter_model = new OAuth_twitter_Model();
		return $oauth_twitter_model->get_user($twitter_id);
	}

	public function login($twitter_user) {
		$oauth_twitter_model = new OAuth_twitter_Model();
		$oauth_twitter_model->login($twitter_user['user_id']);
	}
}
