<?php
if (SiteInfo::is_site_close()) {
  if (UserInfo::is_master_admin()) {
    // do nothing
  } else {
    include 'site_close.php';
    exit();
  }
}
?>
        <div class="row">
          <div class="col-lg-12">
            <!--<div class="well bs-component">-->
              <form class="form-horizontal" method="post" action="<?php echo PC_Config::get('base_url'); ?>/user/login">
              	<input type="hidden" name="login" value="1">
                <fieldset>
                  <legend><?php echo _MD_USER_LOGIN ?></legend>
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
                  </div>
                  <div class="form-group">
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
                  </div>
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                      <button class="btn btn-default"><?php echo _MD_PUMPFORM_CANCEL ?></button>
                      <button type="submit" class="btn btn-primary"><?php echo _MD_USER_LOGIN ?></button>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                      <a href="<?php echo PC_Config::url() ?>/user/remindpass/"><?php echo _MD_USER_REMIND_PASS ?></a>
                    </div>
                  </div>
                </fieldset>
              </form>
            <!--</div>-->
          </div> <!-- end col-lg-12 -->
        </div> <!-- end row -->