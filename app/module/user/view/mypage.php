<input type="hidden" id="_MD_USER_DELETE_USER_REL" value="<?php echo _MD_USER_DELETE_USER_REL ?>">
<input type="hidden" id="_MD_USER_DELETED_USER_REL" value="<?php echo _MD_USER_DELETED_USER_REL ?>">

<!--<div class="row"> -->
    <div class="col-lg-4 profile_image">
        <!--<div class="polaroid">-->
        <!--<p><?php echo htmlspecialchars(UserInfo::get('name')) ?></p>-->
    <?php
        echo PumpImage::get_tag(UserInfo::get('image_id'), 
            300, 
            300,
            array('no_wh' => 1, 'css_width' => 180, 'css_height' => 180));
    ?>
        <!--</div>-->
    </div> <!-- end col-lg-6 -->
    <div class="col-lg-6">
<?php echo UserInfo::get('name'); ?><br />
<?php echo UserInfo::get('email') ?><br />
<?php
if (PC_Config::get('use_tel_auth')) {
    if (UserInfo::get('flg_tel_auth')) {
        echo _MD_USER_TEL_AUTH_OK . "<br />\n";
    } else {
        echo _MD_USER_TEL_AUTH_NO . "<br />\n";
        printf("<a href='%s/user/telauth'>%s</a><br />\n", PC_Config::url(), _MD_USER_TEL_AUTH_DO);
    } 
}
?>
<br />
<a href="<?php echo PC_Config::url() ?>/user/edit/" class="btn btn-default"><?php echo _MD_USER_EDIT_PROFILE ?></a>

<a href="<?php echo PC_Config::url() ?>/user/update_mail/" class="btn btn-default"><?php echo _MD_USER_UPDATE_MAIL ?></a><br />
<?php if (PC_Config::get('use_multi_account')) : ?>
<a href="<?php echo PC_Config::url() ?>/user/user_rel/" class="btn btn-default"><?php echo _MD_USER_ADD_ACCOUNT ?></a><br />
<?php
                  $list = UserInfo::get('rel_user_list');
                  if (! empty($list)) 
                  foreach ($list as $item) : ?>
                    <a class="dropdown-item rel-user-edit-link" id="rel-user-<?php echo $item['id'] ?>"><span class="icon-text" targetid="<?php echo $item['id'] ?>">X<?php printf('<img class="img-circle" src="%s" targetid="%d">', UserInfo::get_icon_url($item['id'], 35, 35), $item['id']); ?>
                    <?php echo htmlspecialchars($item['name']) ?></span></a>
                  <?php endforeach ; ?>
<?php endif ; ?>
<hr />
<a href="<?php echo PC_Config::url() ?>/user/logout/" class="btn btn-default"><?php echo _MD_USER_LOGOUT_LABEL ?></a>
    </div> <!-- end col-lg-6 -->
<!--</div> --><!-- end row -->

<?php include PUMPCMS_APP_PATH . '/module/user/view/confirm_dialog.php'; ?>
<?php include PUMPCMS_APP_PATH . '/module/user/view/info_dialog.php'; ?>

<div class="col-lg-6">
<?php
PC_Hook::hook('user_mypage');
/*
$file = PUMPCMS_APP_PATH . '/module/fanclub/hook/fanclub_hook.php';
if (is_readable($file)) {
    require_once $file;
    $func = $pumpform_config['fanclub']['fanclub']['hook']['user_profile'];
    echo $func();
}
*/
?>
</div>
