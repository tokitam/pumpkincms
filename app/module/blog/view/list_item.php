<?php
require_once PUMPCMS_APP_PATH . '/module/blog/class/blogutil.php';
?>

<br />
<div style="text-align: left;"><!-- one entry -->
<div class="shop_info_title">
    <a href="<?php echo BlogUtil::get_blog_entry_url($item['id']) ?>">
    <?php echo htmlspecialchars($item['title']); ?>
    </a>
</div> <!-- shop_info_title -->
<div style="font-style: italic; text-align: right;">
    <?php echo strftime('%Y/%m/%d %H:%M', $item['reg_time']) ?>
</div>
<?php
if (@$flg_list == false) {
    include 'sns_button.php';
}

if (@$pagebreak) {
    echo PC_Util::strip_tags(PC_Util::split_pagebreak($item['body']));
} else {
    echo PC_Util::strip_tags($item['body']);
}
?>
<?php
if (UserInfo::is_logined() && 
    (@$item['reg_user'] == UserInfo::get_id() || UserInfo::is_master_admin())) :
?>
<div style="text-align: right">
<a href="<?php //echo ShopUtil::info_edit_url($shop_id, $item['id']) ?>"><?php echo _MD_BLOG_EDIT ?></a>
</div>
<?PHP endif ; ?>
</div>