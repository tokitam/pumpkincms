<?php

class ActionLog {
	const LOGIN = 1;
	const LOGOUT = 2;
	const REGISTER_TEMP = 3;
	const REGISTER_FINISH = 4;
	const TEL_AUTH_TEMP = 5;
	const TEL_AUTH_FINISH = 6;

	static public function log($type, $desc='', $param1=0, $param2=0, $param3=0, $param4=0) {

		if (PC_Config::get('enable_action_log') != true) {
			return;
		}

		$ormap = PumpORMAP_Util::getInstance('user', 'actionlog');

		$user_id = UserInfo::get_id();
		$ip_address = ip2long(PC_Util::get_ip_address());
		$user_agent = mb_substr(PC_Util::get_useragent(), 0, 255);
		$desc = mb_substr($desc, 0, 255);

		$arr = array(
			'user_id' => $user_id,
			'type' => $type, 
			'desc' => $desc, 
			'ip_address' => $ip_address,
			'param1' => $param1,
			'param2' => $param2,
			'param3' => $param3,
			'param4' => $param4,
			'user_agent' => $user_agent);

		$ormap->insert($arr);
	}
}
