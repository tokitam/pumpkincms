<?php

require_once(PUMPCMS_APP_PATH . '/module/user/plugin/monthly_stripe/form_config.php');

class monthly_stripe_model {
	function add_customer($customer) {
		$ormap = PumpORMAP_Util::get('user', 'payment_monthly_stripe_customer');
		$data['user_id'] = UserInfo::get_id();
		$data['customer_id'] = $customer['id'];
		$data['account_balance'] = $customer['account_balance'];
		$data['created'] = $customer['created'];
		$data['currency'] = $customer['currency'];
		$data['email'] = $customer['email'];
		if (!empty($customer['sources']['data'][0]['id'])) {
			$data['card_id'] = $customer['sources']['data'][0]['id'];
		} else {
			$data['card_id'] = '';
		}
		$ormap->insert($data);
	}

	function add_subscription($subscription) {
		$ormap = PumpORMAP_Util::get('user', 'payment_monthly_stripe_subscription');
		$data['user_id'] = UserInfo::get_id();
		$data['subscription_id'] = $subscription['id'];
		$data['billing'] = $subscription['billing'];
		$data['cancel_at_period_end'] = $subscription['cancel_at_period_end'];
		$data['canceled_at'] = $subscription['canceled_at'];
		$data['current_period_end'] = $subscription['current_period_end'];
		$data['current_period_start'] = $subscription['current_period_start'];
		$data['customer_id'] = $subscription['customer'];
		$data['ended_at'] = $subscription['ended_at'];
		if (!empty($subscription['items']['data'][0]['id'])) {
			$data['subscription_item_id'] = $subscription['items']['data'][0]['id'];
		} else {
			$data['subscription_item_id'] = '';
		}
		$data['plan_id'] = $subscription['plan']['id'];
		$ormap->insert($data);
	}
	
	function get_last_subscription($user_id) {
		$ormap = PumpORMAP_Util::get('user', 'payment_monthly_stripe_subscription');
		$where = ' user_id = '. intval($user_id);
		$list = $ormap->get_list($where, 0, 1, 'id', true);
		if (empty($list[0]['id'])) {
			return null;
		}
		
		return $list[0];
	}
	
	function update_subscription_canceled_at($id) {
		$db = PC_DBSet::get();
		$ormap = PumpORMAP_Util::get('user', 'payment_monthly_stripe_subscription');
		$ormap->update($id, '', ['canceled_at' => time()]);
	}
}
