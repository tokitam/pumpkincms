<div class="twelve columns">
<!-- <h3><?php echo _MD_USER_REMIND_PASS ?></h3> -->
<p>

<?php if (@$this->message != '') : ?>
<div class="error_message">	
<?php foreach ($this->message as $mes) { echo $mes . "<br />\n"; } ?><br />
</div>
<br />
<?php endif ; ?>

<!--
<form action="<?php echo $this->base_url;?>/user/remindpass/reset/?id=<?php echo $_GET['id']; ?>" method="post">
<input type="hidden" name="post" value="1">
<br />
<div class="form-label"><?php echo _MD_NEW_PASSWORD ?></div>
<input type="password" name="new_password" value="" placeholder="********" required >
	
<div class="form-label"><?php echo _MD_PASSWORD2 ?></div>
<input type="password" name="new_password2" value="" placeholder="********" required >
<br />
<br />

<input type="submit">

</form>
-->


        <div class="row">
          <div class="col-lg-12">
            <!--<div class="well bs-component">-->
              <form class="form-horizontal" method="post" action="<?php echo PC_Config::url(); ?>/user/remindpass/reset/?id=<?php echo $_GET['id']; ?>">
              	<input type="hidden" name="login" value="1">
                <fieldset>
                  <legend><?php echo _MD_USER_REMIND_PASS ?></legend>
                  <div class="form-group">
                    <label for="inputPassword" class="col-lg-3 control-label"><?php echo _MD_NEW_PASSWORD ?></label>
                    <div class="col-lg-9">
                      <input required type="password" class="form-control" id="inputPassword" placeholder="Password" name="new_password">
                      <?php
                      if (@$this->error['password']) {
                        echo $this->error['password'];
                      }
                      ?>
                      <!--
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> Checkbox
                        </label>
                      </div>
                    -->
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword" class="col-lg-3 control-label"><?php echo _MD_NEW_PASSWORD_CONFIRM ?></label>
                    <div class="col-lg-9">
                      <input required type="password" class="form-control" id="inputPassword" placeholder="Password" name="new_password2">
                      <?php
                      //if (@$this->error['password']) {
                      //  echo $this->error['password'];
                      //}
                      ?>
                      <!--
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> Checkbox
                        </label>
                      </div>
                    -->
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                      <button class="btn btn-default">Cancel</button>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </div>
                </fieldset>
              </form>
            <!--</div>-->
          </div> <!-- end col-lg-12 -->
        </div> <!-- end row -->



<br />
	
</p>
</div>
