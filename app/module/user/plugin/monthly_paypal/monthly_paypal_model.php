<?php

class monthly_payapl_model {
	function add_log($param) {
		$ormap = PumpORMAP_Util::get('user', 'payment_monthly_paypal_log');
		$data = [];
		$data['user_id'] = @$param['user_id'];
		$data['method'] = @$param['method'];
		$data['token'] = @$param['token'];
		$data['payerid'] = @$param['payerid'];
		$data['profileid'] = @$param['profileid'];
		$data['profilestatus'] = @$param['profilestatus'];
		$data['timestamp'] = @$param['timestamp'];
		$data['correlationid'] = @$param['correlationid'];
		$data['ack'] = @$param['ack'];
		$data['version'] = @$param['version'];
		$data['build'] = @$param['build'];
		$ormap->insert($data);
	}
	
	function add_user($param) {
		$ormap = PumpORMAP_Util::get('user', 'payment_monthly_paypal_user');
		$data = [];
		$data['user_id'] = @$param['user_id'];
		$data['payerid'] = @$param['payerid'];
		$data['profileid'] = @$param['profileid'];
		$data['del_time'] = 0;
		$ormap->insert($data);
	}
	
	function update_user_del($param) {
		$db = PC_DBSet::get();
		$ormap = PumpORMAP_Util::get('user', 'payment_monthly_paypal_user');
		$data = [];
		$data['del_time'] = @$param['del_time'];
		$where = ' user_id = ' . intval($param['user_id']);
		$where .= ' AND profileid = ' . $db->escape($param['profileid']);
		$ormap->update(0, $where, $data);
	}
	
	function get_profileid($user_id) {
		$ormap = PumpORMAP_Util::get('user', 'payment_monthly_paypal_user');
		$where = ' user_id = ' . intval($user_id) . ' AND del_time <> 0 ';
		$list = $ormap->get_list($where, 0, 1, 'id', true);
		if (empty($list[0]['id'])) {
			return null;
		}
			
		return @$list[0]['profileid'];
	}
}
