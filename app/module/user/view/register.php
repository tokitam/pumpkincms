
        <div class="row">
          <div class="col-lg-12">
            <!--<div class="well bs-component">-->
              <form class="form-horizontal" method="post" action="<?php echo PC_Config::url(); ?>/user/register/">
              	<input type="hidden" name="post" value="1">
              	<?php if (@$_GET['type'] || @$_POST['type']) : ?>
              	<input type="hidden" name="type" value="<?php echo intval(@$_GET['type'] || @$_POST['type']) ?>">
              	<?php endif ; ?>
                <fieldset>
                  <legend><?php echo _MD_USER_REGISTER ?></legend>
                  <div class="form-group">
                    <label for="inputId" class="col-lg-3 control-label"><?php echo _MD_LOGIN_ID ?></label>
                    <div class="col-lg-9">
                      <input required type="text" class="form-control" id="inputId" placeholder="<?php echo _MD_USER_INPUT_ID ?>" name="name" value="<?php echo htmlspecialchars(@$_POST['name']); ?>" pattern="^[0-9A-Za-z]+$" title="<?php echo _MD_USER_INPUT_ID_FORMAT ?>"><br />
			<small><?php echo _MD_USER_INPUT_ID_FORMAT ?></small>
                      <?php
                      if (@$this->error['name']) {
                        echo $this->error['name'];
                      }
                      ?>
                    </div>
                  </div> <!-- from-group -->
                  <div class="form-group">
                    <label for="inputEmail" class="col-lg-3 control-label"><?php echo _MD_LOGIN_EMAIL ?></label>
                    <div class="col-lg-9">
                      <input required type="email" class="form-control" id="inputEmail" placeholder="<?php echo _MD_USER_INPUT_EMAIL ?>" name="email" value="<?php echo htmlspecialchars(@$_POST['email']); ?>">
                      <?php
                      if (@$this->error['email']) {
                        echo $this->error['email'];
                      }
                      ?>
                    </div>
                  </div> <!-- form-group -->
                  <div class="form-group">
                    <label for="inputPassword" class="col-lg-3 control-label"><?php echo _MD_USER_PASSWORD ?></label>
                    <div class="col-lg-9">
                      <input required type="password" class="form-control" id="inputPassword" placeholder="<?php echo _MD_USER_INPUT_PASSWORD ?>" name="password">
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
                  </div> <!-- from-group -->
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
		      <?php echo _MD_UESR_MAIL_DOMAIN_SETTING ?><br />
                      <a href="<?php echo PC_Config::url() ?>/terms" target="_blank" style="font-size: 20px;"><?php echo _MD_USER_TERMS ?></a>
                    </div>
                    <div class="col-lg-10 col-lg-offset-2">
                      <!--<button class="btn btn-default">Cancel</button>-->
                      <button type="submit" class="btn btn-primary"><?php echo _MD_USER_CONFIRM_REGISTER ?></button>
                    </div>
                  </div> <!-- from-group -->
                </fieldset>
              </form>
            <!--</div>-->
          </div> <!-- end col-lg-12 -->
	
          <div class="col-lg-12">
	                    <div class="col-lg-10 col-lg-offset-2">
                            <?php foreach ($this->oauth_tag as $tag) : ?>
	                      <?php echo $tag ?>
	                    <?php endforeach; ?>
	                    </div>
	          </div> <!-- end col-lg-12 -->	
	
        </div> <!-- end row -->


