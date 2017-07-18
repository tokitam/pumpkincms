<?php

if (PC_Util::is_admin_dir()) {
    include PUMPCMS_APP_PATH . '/module/pumpform/view/list.php';
    return;
}

$pn = $this->_data['pagenavi'];
$list = $this->_data['list'];
$flg_list = true;

echo "<h2 id='heading3'>" . PC_Config::get('blog_title') . "</h2>\n";

echo $pn->get_page_link();
$pagebreak = true;

foreach ($list as $item) {
    include 'list_item.php';
    if (preg_match('/<!-- pagebreak -->/s', $item['body'])) {
        printf("<a href='%s' class='morelink'>続きを読む</a><br />\n", BlogUtil::get_blog_entry_url($item['id']));
    }
}

echo $pn->get_page_link();
