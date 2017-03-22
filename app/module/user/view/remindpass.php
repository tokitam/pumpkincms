<div class="twelve columns">
<!-- <h3><?php echo _MD_USER_REMIND_PASS ?></h3> -->
<p>
	
<?php if ($this->sent == false) : ?>	

<?php if (0 < count($this->message)) : ?>
<div class="error_message">	
<?php foreach ($this->message as $mes) { echo $mes . "<br />\n"; }  ?><br />
</div>
<br />
<?php endif ; ?>
	
<!--	
<form action="<?php echo $this->base_url;?>/user/remindpass/" method="post">
<input type="hidden" name="post" value="1">
<br />
<div class="form-label"><?php echo _MD_LOGIN_EMAIL?></div>
<input type="text" name="email" value="<?php echo htmlspecialchars(@$_POST['email']) ?>" pattern="^[\.\-0-9A-Za-z]+@[\.\-0-9A-Za-z]+\.[\.\-0-9A-Za-z]+$" placeholder="id@example.com" required>
<input type="submit">
</form>
-->


        <div class="row">
          <div class="col-lg-12">
            <!--<div class="well bs-component">-->
              <form class="form-horizontal" method="post" action="<?php echo PC_Config::url(); ?>/user/remindpass/">
              	<input type="hidden" name="login" value="1">
                <fieldset>
                  <legend><?php echo _MD_USER_REMIND_PASS ?></legend>
                  <div class="form-group">
                    <label for="inputEmail" class="col-lg-3 control-label"><?php echo _MD_LOGIN_EMAIL ?></label>
                    <div class="col-lg-9">
                      <input required type="email" class="form-control" id="inputEmail" placeholder="Email" name="email" value="<?php echo htmlspecialchars(@$_POST['email']); ?>">
                      <?php
                      if (@$this->error['email']) {
                        echo $this->error['email'];
                      }
                      ?>
                    </div>
                  </div> <!-- from-group-->
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                    	<!--
                      <button class="btn btn-default">Cancel</button>
                  -->
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                  <!--
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                      <a href="<?php echo PC_Config::url() ?>/user/remindpass/"><?php echo _MD_USER_REMIND_PASS ?></a>
                    </div>
                  </div>
              -->
                </fieldset>
              </form>
            <!--</div>-->
          </div> <!-- end col-lg-12 -->
        </div> <!-- end row -->



<?php else : ?>
	
<?php echo @$this->message[0]; ?><br />
<br />
	
<?php endif ; ?>
	
<br />
</p>
</div>
