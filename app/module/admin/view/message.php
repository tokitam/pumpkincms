<div class="twelve columns">
<h3><?php echo '' ?></h3>
<p>

<?php if (0 < count($this->message)) : ?>
<div class="error_message">
<?php foreach ($this->message as $mes) { echo $mes . "<br />\n"; }  ?><br />
</div>
<br />
<?php endif ; ?>

<ul class="nav nav-pills">
  <li><a href="#">PumpkinCMS Version <span class="badge"><?php echo PUMPCMS_VERSION ?></span></a></li>
</ul>

<?php include 'actionlog_list.php'; ?>

<br />

</p>
</div>
