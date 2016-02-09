<?php

require_once PUMPCMS_ROOT_PATH . '/external/twitteroauth.php';

class OAuth {
	const ACCESS_TOKEN_URL = 'https://api.twitter.com/oauth/access_token';

	public function get_tag() {
		$url = PC_Config::url() . '/user/oauth?type=twitter';
		$code = sprintf("location.href = '%s';", $url);
		$tag = sprintf('<button class="btn btn-default" onclick="%s">facebook認証</button>', $code);

		return $tag;
	}

	public function get() {

		$consumer_key = PC_Config::get('twitter_consumer_key');
		$consumer_secret = PC_Config::get('twitter_consumer_secret');
		$callback = PC_Config::url() . '/user/oauth/callback';

	    $_SESSION['consumer_key'] = $consumer_key;
	    $_SESSION['consumer_secret'] = $consumer_secret;

//echo ' consumer_key : ' . $_SESSION['consumer_key'];
//echo ' consumer_secret : ' . $_SESSION['consumer_secret'];
//echo ' callback : ' . $callback;
		$connection = new TwitterOAuth($_SESSION['consumer_key'], $_SESSION['consumer_secret']);
	    $request_token = $connection->getRequestToken($callback);
	    $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
	    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

	    $url = $connection->getAuthorizeURL($token, false);

	    //echo ' url : ' . $url;
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
		$callback = PC_Config::url() . '/';

		$connection = new TwitterOAuth($consumer_key, $consumer_secret, 
			$request_token['oauth_token'], $request_token['oauth_token_secret']);
		$_SESSION['access_token'] = $connection->oAuthRequest(self::ACCESS_TOKEN_URL, 'GET', array('oauth_verifier' => $_REQUEST['oauth_verifier']));

		echo ' access_token: ' . print_r($_SESSION['access_token'], true);
	}
}
