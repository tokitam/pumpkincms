<div class="twelve columns">
<h3><?php echo _MD_USER_REMIND_PASS ?></h3>
<p>

<?php if (0 < count($this->message)) : ?>
<div class="error_message">	
<?php foreach ($this->message as $mes) { echo $mes . "<br />\n"; }  ?><br />
</div>
<br />
<?php endif ; ?>
		

<br />
	
</p>
</div>
