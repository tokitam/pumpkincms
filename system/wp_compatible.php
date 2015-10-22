<?php

function bloginfo($key) {
	if ($key == 'stylesheet_url') {
		echo PC_Config::get('base_url') . '/wptheme/' . PC_Config::get('theme') . '/style.css';
	} else if ($key == 'stylesheet_directory') {
		echo PC_Config::get('base_url') . '/wptheme/' . PC_Config::get('theme');
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
	$file = PUMPCMS_PUBLIC_PATH . '/wptheme/'  . PC_Config::get('theme') . '/header.php';
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
    printf('<link href="%s/wptheme/%s/style.css" type="text/css" rel="stylesheet" />' ."\n", PC_Config::url(), PC_Config::get('theme'));
	printf('<link rel="stylesheet" href="%s/theme/%s/bootstrap.css" media="screen">' ."\n", PC_Config::url(), PC_Config::get('theme'));
    printf('<link rel="stylesheet" href="%s/theme/%s/assets/css/bootswatch.min.css">' ."\n", PC_Config::url(), PC_Config::get('theme'));
    printf('<link rel="stylesheet" href="%s/theme/%s/custom.css">' ."\n", PC_Config::url(), PC_Config::get('theme'));
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
	global $blog_list;

echo ' test1 ';
	if (isset($blog_list) && is_array($blog_list)) {
		if (0 < count($blog_list)) {
			return true;
		} else {
			return false;
		}
	}

	$blog_ormap = PumpORMAP_Util::get('blog', 'blog');

	$blog_list = $blog_ormap->get_list();
//var_dump($blog_list);

	if (0 < count($blog_list)) {
		return true;
	} else {
		return false;
	}


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

	//var_dump($blog);
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
	$file = PUMPCMS_PUBLIC_PATH . '/wptheme/'  . PC_Config::get('theme') . '/sidebar.php';
	include $file;
}

function get_footer() {
	$file = PUMPCMS_PUBLIC_PATH . '/wptheme/'  . PC_Config::get('theme') . '/footer.php';
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
    return PC_Config::url() . '/themes/' . PC_Config::get('default_theme');
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

function get_template_part($arg1, $arg2) {
	global $blog;

	if (isset($blog) && is_array($blog)) {
		//var_dump($blog);

printf('<article id="post-1" class="post-1 post type-post status-publish format-standard hentry category-1">
	<header class="entry-header">
		<h1 class="entry-title"><a href="http://127.0.0.1/wordpress/2015/10/10/hello-world/" rel="bookmark">%s</a></h1>
			<div class="entry-meta entry-header-meta">
		<span class="posted-on">
			<a href="http://127.0.0.1/wordpress/2015/10/10/hello-world/" rel="bookmark"><time class="entry-date published" datetime="2015-10-10T18:27:22+00:00">2015年10月10日</time></a>		</span>
				<span class="byline"><span class="meta-sep"> / </span>
			<span class="author vcard">
				<a class="url fn n" href="http://127.0.0.1/wordpress/author/tokitapumpup-jp/">tokita@pumpup.jp</a>			</span>
		</span>
						<span class="comments-link"><span class="meta-sep"> / </span> <a href="http://127.0.0.1/wordpress/2015/10/10/hello-world/#comments">1件のコメント</a></span>
					</div><!-- .entry-meta -->
				</header><!-- .entry-header -->

		<div class="entry-content">
		<p>%s</p>
			</div><!-- .entry-content -->
	</article><!-- #post-## -->', $blog['title'], $blog['body']);

	} else {
		echo PC_Render::$module_output_static;
	}
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

function wp_nav_menu() {

}

function the_posts_pagination($setting) {

}