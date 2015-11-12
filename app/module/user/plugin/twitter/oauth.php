<?php

require_once PUMPCMS_ROOT_PATH . '/external/twitteroauth/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

class OAuth {
	public function get() {
		echo ' OK ';

		$consumer_key = PC_Config::get('twitter_consumer_key');
		$consumer_secret = PC_Config::get('twitter_consumer_secret');
		$callback = PC_Config::url() . '/user/oauth/oob';

echo ' consumer_key : ' . $consumer_key;
echo ' consumer_secret : ' . $consumer_secret;
echo ' callback : ' . $callback;

		//TwitterOAuth をインスタンス化
		$connection = new TwitterOAuth($consumer_key, $consumer_secret);
var_dump($connection);
		//コールバックURLをここでセット
		$request_token = $connection->oauth('oauth/request_token');
		//$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => $callback));

		//callback.phpで使うのでセッションに入れる
		$_SESSION['oauth_token'] = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

		//Twitter.com 上の認証画面のURLを取得( この行についてはコメント欄も参照 )
		$url = $connection->url('oauth/authenticate', array('oauth_token' => $request_token['oauth_token']));

		echo ' url : ' . $url;
	}
}
