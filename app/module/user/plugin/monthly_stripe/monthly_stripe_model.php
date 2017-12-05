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

	function get_customer($customer_id) {
		$db = PC_DBSet::get();
		$ormap = PumpORMAP_Util::get('user', 'payment_monthly_stripe_customer');
		$where = ' customer_id = ' . $db->escape($customer_id);
		$list = $ormap->get_list($where, 0, 1, 'id', true);
		if (empty($list[0]['id'])) {
			return null;
		}
		
		return $list[0];
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
		$ormap = PumpORMAP_Util::get('user', 'payment_monthly_stripe_subscription');
		$ormap->update($id, '', ['canceled_at' => time()]);
	}
	
	function arrangement_webhook($webhook) {
		$data = [];
		$data['user_id'] = intval(@$webhook['user_id']);
		$data['event_id'] = $webhook['id'];
		$data['type'] = $webhook['type'];
		$data['customer_id'] = '';
		$data['subscription_id'] = '';

		if (!empty($webhook['data']['object']['id'])) {
			$object = $webhook['data']['object'];
			var_dump($object);
			if ($object['object'] == 'customer') {
				$customer = $object;
				$data['customer_id'] = $object['id'];
			} else if ($object['object'] == 'subscription') {
				$subscription = $object;
				$data['subscription_id'] = $object['id'];
			} else if ($object['object'] == 'charge') {
				$charge = $object;
				$data['charge_id'] = $object['id'];
			} else if ($object['object'] == 'invoice') {
				$charge = $object;
				$data['invoice_id'] = $object['id'];
			} else if ($object['object'] == 'source') {
				$charge = $object;
				$data['source_id'] = $object['id'];
			}
		}
		
		if (!empty($object['customer'])) {
			$data['customer_id'] = $object['customer'];
		}
		if (!empty($object['items']['data'][0]['id'])) {
			$data['subscription_item_id'] = $object['items']['data'][0]['id'];
			$plan = @$object['items']['data'][0]['plan'];
		}
		if (!empty($plan['id'])) {
			$data['plan_id'] = $plan['id'];
		} else {
			$data['plan_id'] = '';
		}
		return $data;
	}
	
	function add_webhook($webhook) {
		$ormap = PumpORMAP_Util::get('user', 'payment_monthly_stripe_webhook');
		$ormap->insert($webhook);
	}
}
