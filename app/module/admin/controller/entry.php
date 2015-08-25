<?php

class admin_entry extends PC_Controller {
    public function __construct() {

    	PC_Util::redirect_if_not_site_admin();
    	
		PumpForm::$redirect_url = PC_Config::url() . '/admin/shop/';

		PC_Util::include_language_file('shop');
		PumpFormConfig::load_config('shop');

		global $pumpform_config;
		$pumpform_config['shop']['shop']['column']['status']['visible'] = 1;
		$pumpform_config['shop']['shop']['column']['status']['editable'] = 1;
		$pumpform_config['shop']['shop']['column']['status']['registable'] = 1;
		$pumpform_config['shop']['shop']['column']['status']['list_visible'] = 1;
//var_dump($pumpform_config);

		$this->_flg_scaffold = true;
		$this->_module = 'shop';
		$this->_table = 'entry';
    }

    public function publish() {
    	
    	$service_url = PC_Config::get('service_url');

		preg_match('@admin/entry/publish/([0-9]+)@', $service_url, $r);
		if (is_numeric($r[1]) == false) {
			PC_Util::redirect_top();
		}
		$entry_id = $r[1];

		$entry_map = PumpORMAP_Util::getInstance('shop', 'entry');
		$entry = $entry_map->get($entry_id);

		// 画像IDを整数として扱う
		PumpFormConfig::load_config('shop');
		global $pumpform_config;
		$pumpform_config['shop']['shop']['column']['header_image_id']['type'] = PUMPFORM_INT;
		$pumpform_config['shop']['shop']['column']['list_image_id']['type'] = PUMPFORM_INT;
		$pumpform_config['shop']['shop']['column']['bg_image_id']['type'] = PUMPFORM_INT;

		$shop_map = PumpORMAP_Util::getInstance('shop', 'shop');

		unset($entry['id']);
		$entry['status'] = ShopDefine::PENDING;

		$shop_map->insert($entry);

		echo '登録しました';
    }
}
