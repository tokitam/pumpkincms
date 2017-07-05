<div class="twelve columns">
<h3><?php echo _MD_USER_REMIND_PASS ?></h3>
<p>

<form action="<?php echo $this->base_url;?>/user/remindpass/" method="post">
<input type="hidden" name="post" value="1">
<br />

<div class="form-label"><?php echo _MD_OLD_PASSWORD ?></div>
<input type="pasword" name="password" value="" placeholder="********" >

<div class="form-label"><?php echo _MD_NEW_PASSWORD ?></div>
<input type="pasword" name="password" value="" placeholder="********" >

<div class="form-label"><?php echo _MD_PASSWORD2 ?></div>
<input type="pasword" name="password" value="" placeholder="********" >
<br />
<br />

<input type="submit">

</form>

<br />

</p>
</div>
