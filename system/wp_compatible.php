<?php

function bloginfo($key) {
	if ($key == 'stylesheet_url') {
		echo PC_Config::get('base_url') . '/wpthemes/' . PC_Config::get('layout') . '/style.css';
	} else if ($key == 'stylesheet_directory') {
		echo PC_Config::get('base_url') . '/wpthemes/' . PC_Config::get('layout');
	} else if ($key == 'name') {
		echo PC_Config::get('site_title');
	} else if ($key == 'description') {
		echo PC_Config::get('description');
	} else if ($key == 'charset') {
		echo 'UTF-8';
	}
}

function get_bloginfo($key) {
}

function __($s) {

}

function get_header() {
	$file = PUMPCMS_PUBLIC_PATH . '/wpthemes/'  . PC_Config::get('layout') . '/header.php';
	include $file;
}

function wp_title($a, $b, $c) {
  	echo PC_Config::get('site_title');
}

function is_single() {
	return true;
}

function is_singular() {

}

function wp_enqueue_script() {

}

function wp_head() {
    printf('<link href="%s/wpthemes/%s/style.css" type="text/css" rel="stylesheet" />', PC_Config::url(), PC_Config::get('default_layout'));
    printf('<link href="%s/themes/idoldd/custom.css" type="text/css" rel="stylesheet" />', PC_Config::url(), PC_Config::get('default_layout'));
    echo '
	   <link rel="stylesheet" href="http://idoldd.com/themes/idoldd/bootstrap.css" media="screen">
        <link rel="stylesheet" href="http://idoldd.com/themes/idoldd/assets/css/bootswatch.min.css">
          <link rel="stylesheet" href="http://idoldd.com/themes/idoldd/custom.css">
      ';
}

function wp_footer() {
echo <<< EOM
	<p>
		tokita test blog is proudly powered by <a href="http://wordpress.org/">WordPress</a>		<br /><a href="http://127.0.0.1/dev/wordpress/?feed=rss2">Entries (RSS)</a> and <a href="http://127.0.0.1/dev/wordpress/?feed=comments-rss2">Comments (RSS)</a>.		<!-- 25 queries. 9.136 seconds. -->
	</p>
EOM;
}

function body_class() {

}

function get_option() {

}

function have_posts() {
/*
	global $blog_list;

	PC_Util::include_language_file('blog');

	if (@$blog_list && 0 < count($blog_list)) {
		return true;
	}

	$pumpform = new PumpForm();
	$blog_list = $pumpform->get_list('blog', 'blog');

	//var_dump($blog_list);

	if (0 < count($blog_list)) {
		return true;
	} else {
		return false;
	}
*/
}

function the_post() {
	global $blog_list;
	global $blog;

	$blog = array_shift($blog_list);
}

function the_tags() {

}

function edit_post_link() {

}

function comments_popup_link($a, $b, $c, $d, $e) {

}

function next_posts_link($s) {

}

function previous_posts_link($s) {

}

function get_num_queries() {

}

function timer_stop() {

}

function _e($a, $b){

}

function post_class() {

}

function the_ID() {

}

function the_title_attribute() {

}

function get_the_category_list() {

}

function the_permalink() {
	echo PC_Config::get('base_url') . '/';
}

function the_title() {

}

function the_time($s) {
	echo strftime($s, time());
}

function the_author() {

}
function the_content($s) {
	global $blog;

	echo "<p>";
	//echo htmlspecialchars($blog['body']);
	var_dump($blog);
	echo "</p>";
}

function get_search_form() {

}

function get_sidebar() {
	$file = PUMPCMS_PUBLIC_PATH . '/wpthemes/'  . PC_Config::get('layout') . '/sidebar.php';
	include $file;
}

function get_footer() {
	$file = PUMPCMS_PUBLIC_PATH . '/wpthemes/'  . PC_Config::get('layout') . '/footer.php';
	include $file;
}

function language_attributes() {
	// do nothing
}

function is_404() {
}

function is_category() {
}

function is_day() {
}

function is_month() {
}

function is_year() {
}

function is_search() {
}

function is_paged() {
} 

function wp_list_pages() {

}

function wp_get_archives() {

}

function wp_list_categories() {

}

function is_home() {

}

function is_page() {

}

function esc_url($url, $protocols=null, $context='display') {
    if (preg_match('/(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/', $url, $r)) {
	return $r[1] . $r[2];
    } else {
	return '';
    }
}

function get_template_directory_uri() {
    return PC_Config::url() . '/themes/' . PC_Config::get('default_layout');
}

function is_front_page() {
    return '';
}

function home_url() {
    return PC_Config::url() . '/';
}

function is_customize_preview() {
}

function has_nav_menu() {
}

function is_active_sidebar() {
}

function get_template_part() {
    echo PC_Render::$module_output_static;
}

function get_post_format() {
}

function do_action() {
}

function get_webmaster_tool_id() {
}

function is_facebook_ogp_enable() {
}

function is_twitter_cards_enable() {
}

function get_header_image() {
}

function get_theme_mod() {
}



