<?php
if (PC_Util::is_admin_dir()) {
    include PUMPCMS_APP_PATH . '/module/pumpform/view/detail.php';
    return;
}

require_once PUMPCMS_APP_PATH . '/module/blog/class/blogutil.php';

$item = $this->_data['item'];

echo "<h2 id='heading3'>" . PC_Config::get('blog_title') . "</h2>\n";

$url = BlogUtil::get_blog_top_url();
$tag = sprintf('<div style="text-align: right;"><a href="%s">%s</a></div>', $url, _MD_BLOG_TO_LIST);

echo $tag;

include 'list_item.php';

echo $tag;

