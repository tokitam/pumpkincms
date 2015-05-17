<!--<div class="row"> -->
	<div class="col-lg-4">
		<!--<div class="polaroid">-->
		<!--<p><?php echo htmlspecialchars(UserInfo::get('name')) ?></p>-->
	<?php
		echo PumpImage::get_tag(UserInfo::get('image_id'), 
			180, 
			180,
			array('no_wh' => 1));
	?>
		<!--</div>-->
	</div> <!-- end col-lg-6 -->
	<div class="col-lg-6">
<?php echo UserInfo::get('name'); ?><br />
<?php echo UserInfo::get('email') ?><br />
<?php
if (UserInfo::get('flg_tel_auth')) {
    echo _MD_USER_TEL_AUTH_OK . "<br />\n";
} else {
    echo _MD_USER_TEL_AUTH_NO . "<br />\n";
    printf("<a href='%s/user/telauth'>%s</a><br />\n", PC_Config::url(), _MD_USER_TEL_AUTH_DO);
} 
?>
<br />
<a href="<?php echo PC_Config::url() ?>/user/edit/" class="btn btn-default"><?php echo _MD_USER_EDIT_PROFILE ?></a>
	</div> <!-- end col-lg-6 -->

<!--</div> --><!-- end row -->
