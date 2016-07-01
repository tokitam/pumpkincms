
        <div class="row">
          <div class="col-lg-12">
            <!--<div class="well bs-component">-->
              <form class="form-horizontal" method="post">
              	<input type="hidden" name="login" value="1">
                <fieldset>
                  <legend><?php echo _MD_USER_ADD_ACCOUNT ?></legend>
                  <div class="form-group">
                    <div class="row">
                    <label for="inputEmail" class="col-lg-3 control-label"><?php echo _MD_LOGIN_EMAIL ?></label>
                    <div class="col-lg-9">
                      <input required type="email" class="form-control" id="inputEmail" placeholder="Email" name="email" value="<?php echo htmlspecialchars(@$_POST['email']); ?>">
                      <?php
                      if (@$this->error['email']) {
                        echo $this->error['email'];
                      }
                      ?>
                    </div>
                    </div> <!-- row -->
                  </div> <!-- form-group -->
                  <div class="form-group">
                    <div class="row">
                    <label for="inputPassword" class="col-lg-3 control-label"><?php echo _MD_USER_PASSWORD ?></label>
                    <div class="col-lg-9">
                      <input required type="password" class="form-control" id="inputPassword" placeholder="Password" name="password">
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
                    </div> <!-- row -->
                  </div> <!-- from-group -->
                  <div class="form-group">
                    <div class="row">
                    <div class="col-lg-10 col-lg-offset-2">
                      <button class="btn btn-default"><?php echo _MD_PUMPFORM_CANCEL ?></button>
                      <button type="button" class="btn btn-primary" id="pumpform_add_account_button"><?php echo _MD_USER_ADD ?></button>
                    </div>
                    </div> <!-- row -->
                  </div> <!-- form-group -->
                  <?php /*
                  <div class="form-group">
                    <div class="row">
                    <div class="col-lg-10 col-lg-offset-2">
                      <a href="<?php echo PC_Config::url() ?>/user/remindpass/"><?php echo _MD_USER_REMIND_PASS ?></a>
                      <a href="<?php echo PC_Config::get('base_url'); ?>/user/register/"><?php echo _MD_USER_REGISTER ?></a>
                    </div>
                    </div> <!-- row -->
                  </div> <!-- form-group -->
                  */ ?>
                </fieldset>
              </form>
            <!--</div>-->
          </div> <!-- end col-lg-12 -->
          <?php /*
          <div class="col-lg-12">
                    <div class="col-lg-10 col-lg-offset-2">
                    <?php foreach ($this->oauth_tag as $tag) : ?>
                      <?php echo $tag ?>
                    <?php endforeach; ?>
                    </div>
          </div> <!-- end col-lg-12 -->
        </div> <!-- end row -->
        */ ?>



    <div class="modal fade" id="pumpform-add-account-dialog" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">

            <div class="modal-content">
                <div class="modal-header">
                        <span id="add-account-dialog-title"></span>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <button type="button" class="btn btn-danger" id="add-account-button"><?php echo _MD_USER_BACK ?></button>
                </div>
            </div>
        </div>
    </div>
