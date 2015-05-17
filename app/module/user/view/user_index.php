<div class="twelve columns">
<h2><?php echo _MD_USER_LOGIN?></h2	>
<p>

<br />
<br />

<?php if (@$_SESSION['login']) { ?>
<div>
logined<br />
<br />
<a href="<?php echo PC_Config::get('base_url'); ?>/user/logout/">[LOGOUT]</a>
</div>
<?php } else { ?>

<?php if (isset($this->error)) : ?>
<p>
<?php foreach ($this->error as $err): ?>
<?php echo $err ?><br />
<?php endforeach ; ?>
</p>

<?php endif ; ?>

<form method="POST" action="<?php echo PC_Config::get('base_url'); ?>/user/login">
<input type="hidden" name="login" value="1">
<div class="form-label pumpform_label"><?php echo _MD_LOGIN_EMAIL?></div> 
<input type="email" class="pumpform_input" name="email" value="<?php echo htmlspecialchars(@$_POST['email']); ?>">
<div class="form-label pumpform_label"><?php echo _MD_PASSWORD?></div> 
<input type="password" class="pumpform_input" name="password">
<!-- <input type="checkbox"><?php echo _MD_USER_KEEP_ME_LOGGED_IN; ?><br /> -->
<br />
<input type="submit" class="pumpform_button">
</form>

<br />
<a href="<?php echo PC_Config::get('base_url'); ?>/user/register/"><?php echo _MD_USER_REGISTER ?></a><br />
<a href="<?php echo PC_Config::get('base_url'); ?>/user/remindpass/"><?php echo _MD_USER_FORGOT_PASSWORD ?></a><br />

<?php } ?>

</P>
</div>

