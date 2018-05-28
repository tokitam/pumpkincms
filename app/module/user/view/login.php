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
              <form class="form-horizontal" method="post" action="<?php echo PC_Config::url(); ?>/user/login">
                <input type="hidden" name="login" value="1">
                <?php Csrf_protection::set_csrf_token(); echo Csrf_protection::get_form_part(); ?>
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
                  </div> <!-- form-group -->
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
                  </div> <!-- from-group -->
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                      <button class="btn btn-default"><?php echo _MD_PUMPFORM_CANCEL ?></button>
                      <button type="submit" class="btn btn-primary"><?php echo _MD_USER_LOGIN ?></button>
                    </div>
                  </div> <!-- form-group -->
                  <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                      <a href="<?php echo PC_Config::url() ?>/user/remindpass/"><?php echo _MD_USER_REMIND_PASS ?></a>
                      <?php if (PC_Config::get('allow_register')) : ?>

                      <a href="<?php echo PC_Config::get('base_url'); ?>/user/register/"><?php echo _MD_USER_REGISTER ?></a>
                      <?php endif ; ?>  
                    </div>
                  </div> <!-- form-group -->
                </fieldset>
              </form>
            <!--</div>-->
          </div> <!-- end col-lg-12 -->
          <?php if (!empty($this->oauth_tag)) : ?>
          <div class="col-lg-12">
                    <div class="col-lg-10 col-lg-offset-2">
                    <?php foreach ($this->oauth_tag as $tag) : ?>
                      <?php echo $tag ?>
                    <?php endforeach; ?>
                    </div>
          </div> <!-- end col-lg-12 -->
          <?php endif ; ?>
        </div> <!-- end row -->
