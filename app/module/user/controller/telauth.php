<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';

class user_telauth extends PC_Controller {
    public $code;
    
	public function index() {
		$this->render();
	}

	public function auth() {
	    if (UserInfo::is_logined() == false) {
		PC_Util::redirect_top();
	    }

	    if (@$_POST['tel_code'] == '' ||
	    	@$_POST['tel'] == '' ||
	    	@$_POST['tel_country'] == '') {
	    	PC_Util::redirect(PC_Config::url() . '/user/telauth');
	    }
	    
	    UserInfo::reload();
	    
	    if (UserInfo::get('flg_tel_auth')) {
		echo "<legend>電話認証</legend><br />\n";
		echo '認証済です';
		return;
	    }
	    
	    //var_dump($_POST);
	    $path = PUMPCMS_ROOT_PATH . '/external/twilio/';
	
	    set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	    require_once 'Services/Twilio.php';
	      
	    $code = @$_POST['tel_code'];
	    $tel = preg_replace('/-/', '', @$_POST['tel']);
	    
	    $check_string = rand(100000, 999999) . uniqid();
	    $telauth = PumpORMAP_Util::getInstance('user', 'tel_auth');
	    $data = array('user_id' => UserInfo::get_id(), 
			  'code' => $code, 
			  'check_string' => $check_string,
			  'user_id' => UserInfo::get_id(),
			  'tel_country' => @$_POST['tel_country'],
			  'tel_no' => $tel,
			  );
	    $telauth_id = $telauth->insert($data);

	    ActionLog::log(ActionLog::TEL_AUTH_TEMP, '', UserInfo::get_id());

	    //$url = sprintf('%s/user/telauth/twiml?c=%d_%s', PC_Config::url(), $telauth_id, $check_string);
	    $url = sprintf('%s/user/telauth/twiml?id=%d', PC_Config::url(), $telauth_id);
	    
	    $auth_tel_no = substr_replace($tel, @$_POST['tel_country'], 0, 1);
	    $account_sid = PC_Config::get('twilio_account_sid');
	    $auth_token = PC_Config::get('twilio_auth_token');
	    
	    $client = new Services_Twilio($account_sid, $auth_token);
	    //echo "<br />\n";

	    try {
		    $call = $client->account->calls->create(
		    	PC_Config::get('twilio_from_telno'), // From a Twilio number in your account
		    	$auth_tel_no, // From a Twilio number in your account
		    	$url
		    );
	    } catch (Exception $e) {
		echo "メンテナンス中です。しばらくしてから再度お試しください。";
		if (UserInfo::is_master_admin()) {
		    echo $e->getMessage();
		}
		return;
	    }

	    $this->code = $code;

	    $this->render('auth');
	}
    
    public function authok($id, $check_string) {
	$telauth = PumpORMAP_Util::getInstance('user', 'tel_auth');
	$db = PC_DBSet::get();
	if (preg_match('/^([0-9A-Za-z]+)$/', $check_string, $r) == false) {
	    exit();
	}
	$where = sprintf(" id = %d AND check_string = %s", $id, $db->escape($check_string));
	$list = $telauth->get_list($where, 0, 1);
	$c = $list[0];
	$user_id = $c['user_id'];
	
	$user_model = new User_Model();
	
	$user_map = PumpORMAP_Util::getInstance('user', 'user');
	$where = " tel_country = " . $db->escape($c['tel_country']);
	$where .= " AND tel_no = " . $db->escape($c['tel_no']);
	$list = $user_map->get_list($where, 0, 10);

	$vote_disable_time = 0;
	
	if (0 < count($list)) {
	    foreach ($list as $u) {
		$user_model->update_flg_tel_auth($u['id'], 0, '', '', 0);
	    }
	    $vote_disable_time = time() + (60 * 60 * 24);
	}

	$user_model->update_flg_tel_auth($c['user_id'], 1, $c['tel_country'], $c['tel_no'], $vote_disable_time);
	    ActionLog::log(ActionLog::TEL_AUTH_FINISH, '', $user_id);
    }
    
    public function twiml() {
	$telauth = PumpORMAP_Util::getInstance('user', 'tel_auth');
	$where = sprintf('id = %d', @$_GET['id']);;
	$list = $telauth->get_list($where, 0, 1);
	if (count($list) == 0) {
	    exit();
	}
	
	$c = @$list[0];
	
	$val_two = $c['code'];
	$val_two_strlen = strlen($c['code']);
	
	if (@$_GET['Digits']) {
	    $_POST['Digits'] = $_GET['Digits'];
	}
	
	header("content-type: text/xml");
	
	echo "<Response>\n";
	if (empty($_POST["Digits"])) {
	    //echo '<Say language="ja-jp">画面に表示されている認証コードを押してください。</Say>' . "\n";
	    echo '<Say language="ja-jp">' . PC_Config::get('tel_auth_message') . '</Say>' . "\n";
	    echo '<Gather numDigits="' . $val_two_strlen . '" timeout="20" />' . "\n";
	} else if ($_POST["Digits"] == $val_two) {
	    echo '<Say language="ja-jp">認証を完了しました。</Say>' . "\n";
	    echo '<Gather numDigits="' . $val_two_strlen . '" timeout="20" >' . "\n";
	    echo '    <Say language="ja-jp">認証を終了します。電話をお切りください。</Say>' . "\n";
	    echo "</Gather>\n";
	    $this->authok($c['id'], $c['check_string']);
	} else if ($_POST["Digits"] != $val_two) {
	    echo '<Say language="ja-jp">番号をもう一回確認してやり直してください。</Say>' . "\n";
	    echo '<Gather numDigits="' . $val_two_strlen . '" timeout="20" />' . "\n";
	}
	echo "</Response>\n";
	exit();
    }
}

