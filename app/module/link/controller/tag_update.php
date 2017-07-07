<?php

class link_tag_update extends PC_Controller {
    public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		PC_Util::redirect_if_not_site_admin();
		
		$link_ormap = PumpORMAP_Util::get('link', 'link');
		$tag_ormap = PumpORMAP_Util::get('link', 'tag');
		$rel_ormap = PumpORMAP_Util::get('link', 'tag_rel');
		
		$link_list = $link_ormap->get_list('', 0, 10000);

		$tag_list = [];
		$link_ids = [];
		foreach ($link_list as $link) {
			$list = explode(',', $link['tag']);
			foreach ($list as $t) {
				if (empty($tag_list[$t])) {
					$tag_list[$t] = 1;
				} else {
					$tag_list[$t]++;
				}
				$link_ids[$t] = $link['id'];
			}
		}
		
		$tag_ormap->delete_where(1);
		$rel_ormap->delete_where(1);
		
		foreach ($tag_list as $key => $val) {
			$t = ['tag' => $key, 'count' => $val];
			$tag_id = $tag_ormap->insert($t);

			$link_id = $link_ids[$key];
			$l = ['link_id' => $link_id, 'tag_id' => $tag_id];
			$rel_ormap->insert($l);
		}
		
		var_dump($tag_list);
	}
}
