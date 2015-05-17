<div class="twelve columns">
<h3><?php echo _MD_USER_REGISTER ?></h3>
<p>

<?php //$f = new PumpForm(); echo $f->getForm('user', 'user); ?>

<hr />

<form action="<?php echo $this->base_url;?>/user/finish/" method="post">
<br />
<div class="form-label"><?php echo _MD_LOGIN_NAME?></div>
<input type="text" name="user-name" value="<?php echo htmlspecialchars($_POST['user-name']) ?>" pattern="^[0-9A-Za-z]+$" placeholder="name" autocomplete="off"  required> 
<div class="form-label"><?php echo _MD_LOGIN_EMAIL?></div>
<input type="text" mame="user-email" value="<?php echo htmlspecialchars($_POST['user-email']) ?>" pattern="^[\.\-0-9A-Za-z]+@[\.\-0-9A-Za-z]+\.[\.\-0-9A-Za-z]+$" placeholder="id@example.com" required>
<div class="form-label"><?php echo _MD_PASSWORD?></div>
<input type="text" mame="user-password" value="*********" disabled>
<input type="submit" value="<?php echo _MD_USER_REGISTER ?>">
</form>

</p>
</div>
