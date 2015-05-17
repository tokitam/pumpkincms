<?php
// ↓ほかのテンプレートを読む可能性があるので注意
$template_file = PUMPCMS_APP_PATH . '/layout/' . PC_Config::get('layout') . '/template/user_index.php';
if (is_readable($template_file)) {
	include $template_file;
	return;
}
?>

<div class="twelve columns">
<p>

<?php if (UserInfo::is_logined()) { ?>
<h3><?php echo _MD_USER_MYPAGE ?></h3>
<?php include 'mypage.php'; ?>

<?php } else { ?>

<?php if (isset($this->error)) : ?>
<p>
<?php foreach ($this->error as $err): ?>
<?php echo $err ?><br />
<?php endforeach ; ?>
</p>

<?php endif ; ?>
<?php include 'login.php' ?>

<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />

<?php } ?>

</P>
</div>

