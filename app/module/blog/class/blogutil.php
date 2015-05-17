<?php

require_once PUMPCMS_APP_PATH . '/module/blog/class/blogdefine.php';

class BlogUtil {
	static public function get_blog_top_url() {
		return sprintf('%s/%s', PC_Config::url(), PC_Config::get('blog_dir'));
	}

	static public function get_blog_entry_url($id) {
		$dir = BlogUtil::get_dir(PC_Config::get('blog_id'));
		return sprintf('%s/%s/%d', PC_Config::url(), $dir, $id);
	}

	static public function blog_block($blog_id=1) {
		PC_Config::set('blog_id', $blog_id);
		include PUMPCMS_APP_PATH . '/module/blog/view/blog_block.php';
	}

	static public function get_dir_list() {
		$list = array();
		$blog = PC_Config::get('blog');

		if (is_array($blog) == false || count($blog) == 0) {
			return $list;
		}

		foreach ($blog as $key => $b) {
			$list[$key] = $b['dir'];
		}

		return $list;
	}

	static public function get_dir($blog_id) {
		$blog = PC_Config::get('blog');
		if (@$blog[$blog_id]['dir']) {
			return $blog[$blog_id]['dir'];
		}

		return BlogDefine::DEFAULT_BLOG_DIR;
	}

	static public function get_title($blog_id) {
		$blog = PC_Config::get('blog');
		if (@$blog[$blog_id]['title']) {
			return $blog[$blog_id]['title'];
		}

		return BlogDefine::DEFAULT_BLOG_TITLE;
	}
}
