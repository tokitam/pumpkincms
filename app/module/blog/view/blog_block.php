<?php

require_once PUMPCMS_APP_PATH . '/module/blog/class/blogdefine.php';
require_once PUMPCMS_APP_PATH . '/module/blog/class/blogutil.php';

$ormap = PumpORMAP_Util::getInstance('blog', 'blog');
$where = 'status = ' . intval(BlogDefine::OPEN);
if (PC_Config::get('blog_id')) {
    $where .= ' AND blog_id = ' . intval(PC_Config::get('blog_id'));
}
$list = $ormap->get_list($where, 0, 10);

echo "<table class='table table-striped table-hover block_info_title'>\n<tbody>\n";
echo BlogUtil::get_title(PC_Config::get('blog_id'));

foreach ($list as $item) {
    $title = $item['title'];
    echo "<tr>\n";
    printf("<td style='text-align: left; '><a href='%s'>%s</a></td><td>%s</td>\n",
        BlogUtil::get_blog_entry_url($item['id'], $item['blog_id']),
        htmlspecialchars(PC_Util::mb_truncate($title)),
        strftime('%Y/%m/%d', $item['reg_time'])
        );
    echo "</tr>\n";
}

echo "</tbody></table>\n";

