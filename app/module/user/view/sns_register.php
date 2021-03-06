
        <div class="row">
          <div class="col-lg-12">
            <!--<div class="well bs-component">-->
              <form class="form-horizontal" method="post" action="<?php echo PC_Config::url(); ?>/user/oauth/register/">
                <input type="hidden" id="base_url" value="<?php echo PC_Config::url() ?>">
                <input type="hidden" name="post" value="1">
                <input type="hidden" name="type" value="<?php echo htmlspecialchars(@$this->type) ?>">
                <fieldset>
                  <legend><?php echo _MD_USER_REGISTER ?></legend>
                  <div class="form-group">
                    <label for="inputId" class="col-lg-3 control-label"><?php echo _MD_LOGIN_ID ?></label>
                    <div class="col-lg-9">
                      <input required type="text" class="form-control" id="inputId" placeholder="<?php echo _MD_USER_INPUT_ID ?>" name="name" value="<?php echo htmlspecialchars(@$_POST['name']); ?>" pattern="^[0-9A-Za-z]+$" title="<?php echo _MD_USER_INPUT_ID_FORMAT ?>"><br />
                      <span class="label label-danger" id="input_id_label" style="display: none;">* Input ID<br /></span>
                      <span class="label label-danger" id="duplicate_id_label" style="display: none;">* Duplicate ID<br /></span>
                      <small><?php echo _MD_USER_INPUT_ID_FORMAT ?></small>
                      <?php
                      if (@$this->error['name']) {
                        echo $this->error['name'];
                      }
                      ?>
                    </div>
                  </div>
                  <?php if ($this->oauth->input_email) : ?>
                  <div class="form-group">
                    <label for="inputEmail" class="col-lg-3 control-label"><?php echo _MD_LOGIN_EMAIL ?></label>
                    <div class="col-lg-9">
                      <input required type="email" class="form-control" id="inputEmail" placeholder="<?php echo _MD_USER_INPUT_EMAIL ?>" name="email" value="<?php echo htmlspecialchars(@$_POST['email']); ?>">
                      <span class="label label-danger" id="input_email_label" style="display: none;">* Input Email</span>
                      <?php
                      if (@$this->error['email']) {
                        echo $this->error['email'];
                      }
                      ?>
                    </div>
                  </div>
                  <?php endif ; ?>
                  <?php if ($this->oauth->input_password) : ?>
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
                  </div>
                  <?php endif ; ?>
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                  <?php if ($this->oauth->input_email) : ?>
                    <?php echo _MD_UESR_MAIL_DOMAIN_SETTING ?><br />
                  <?php endif ; ?>
                      <a href="<?php echo PC_Config::url() ?>/terms" target="_blank" style="font-size: 20px;"><?php echo _MD_USER_TERMS ?></a>
                    </div>
                    <div class="col-lg-10 col-lg-offset-2">
                      <!--<button class="btn btn-default">Cancel</button>-->
                      <button button="submit" id="submit_button" class="btn btn-primary"><?php echo _MD_USER_CONFIRM_REGISTER ?></button>
                    </div>
                  </div>
                </fieldset>
              </form>
            <!--</div>-->
          </div> <!-- end col-lg-12 -->
        </div> <!-- end row -->


