<?php if (defined('PUMPCMS_ROOT_PATH') == false) { exit(); } ?><!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title><?php echo SiteInfo::get('site_title'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="<?php echo SiteInfo::get_css_url(); ?>/theme/<?php echo SiteInfo::get('theme') ?>/bootstrap.css" media="screen">
    <link rel="stylesheet" href="<?php echo SiteInfo::get_css_url(); ?>/theme/<?php echo SiteInfo::get('theme') ?>/assets/css/bootswatch.css">
    <link rel="stylesheet" href="<?php echo SiteInfo::get_css_url(); ?>/theme/<?php echo SiteInfo::get('theme') ?>/custom.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../bower_components/html5shiv/dist/html5shiv.js"></script>
      <script src="../bower_components/respond/dest/respond.min.js"></script>
    <![endif]-->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

    <script type="text/javascript">

    $(document).ready(function() {
      
      <?php 
        if (PC_Notification::exists()) {
          echo "pc_notification('" . PC_Notification::get() . "');\n";
          PC_Notification::clear();
        }  
      ?>
        var dummy = 0;
      });

     var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-23019901-1']);
      _gaq.push(['_setDomainName', "bootswatch.com"]);
        _gaq.push(['_setAllowLinker', true]);
      _gaq.push(['_trackPageview']);

     (function() {
  //     var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  //     ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  //     var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
     })();

    </script>
  </head>
  <!-- <body> -->
<?php if (PC_Config::get('bg_image_url')) : ?>  
  <body style='background-image: url("<?php echo PC_Config::get('bg_image_url') ?>"); background-repeat: repeat;'>
<?php else : ?>    
  <body style='background-image: url("<?php echo SiteInfo::get_css_url(); ?>/theme/<?php echo SiteInfo::get('theme') ?>/pattern8-pattern-26b.png");'>
<?php endif ; ?>  
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header" style="border: 1px;">
          <a href="<?php echo PC_Config::url() ?>" class="navbar-brand">PumpkinCMS</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar-main">

          <ul class="nav navbar-nav navbar-right">

<?php if (UserInfo::is_logined()) : ?>

<?php if (UserInfo::is_master_admin()) : ?>
            <li>
              <a href="<?php echo PC_Config::url() ?>/admin/"><?php echo _MD_USER_MASTER_ADMIN ?></a>
            </li>
<?php endif ;  ?>

                    <li class="dropdown user user-menu">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo UserInfo::get('name') ?> <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li class="user-header">
<?php if (0 < UserInfo::get('image_id')) : ?>
                                    <img src="<?php echo PumpImage::get_url(UserInfo::get('image_id'), 215, 215, array('crop' => 1)) ?>" class="image-circle" />
<?php else : ?>                          
                                    <img src="<?php echo PC_Config::url() ?>/image/no_image.png" class="image-circle" />
<?php endif ; ?>                          
                                    <p>
                                        <?php echo UserInfo::get('name') ?>
                                        <small><?php echo _MD_PUMPFORM_LAST_LOGIN ?> <?php echo strftime('%Y/%m/%d %H:%M', UserInfo::get('last_login_time')) ?></small>
                                    </p>
                        </li>
                        <li class="user-footer">
                                    <div class="pull-left">
                                        <a class="btn btn-link" href="<?php echo PC_Config::url() ?>/user/" class="btn btn-default btn-flat"><?php echo _MD_PUMPFORM_PROFILE ?></a>
                                    </div>
                                    <div class="pull-right">
                                        <a class="btn btn-link" href="<?php echo PC_Config::url() ?>/user/logout" class="btn btn-default btn-flat"><?php echo _MD_PUMPFORM_LOGOUT ?></a>
                                    </div>                          
                        </li>
                      </ul>
                    </li>
<?php else : ?>
            <li>
              <a href="<?php echo PC_Config::url() ?>/user/register"><?php echo _MD_PUMPFORM_SIGNUP ?></a>
            </li>                    
            <li>
              <a href="<?php echo PC_Config::url() ?>/user/"><?php echo _MD_PUMPFORM_SIGNIN ?></a>
            </li>                    
<?php endif ; ?>

          </ul>


        </div>
      </div>
    </div>

    <div class="container">
      <div class="page-header" id="banner">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 main_content">
            <?php $this->module_render(); ?>  
          </div>
          <div class="col-xs-4 col-sm-4 visible-xs visible-sm invisible-md invisible-lg ">
    <br />
          </div>

          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

            <p>
            <?php //include PUMPCMS_APP_PATH . '/module/shop/view/ad_300x250_1.php' ?>
            <?php //include PUMPCMS_APP_PATH . '/module/shop/view/ad_300x250_2.php' ?>
            </p>
            <br />

            <div class="vote_rank_content">
<!--              
<script>
  (function() {
    var cx = '014342331845379084623:_dklgh2sroq';
    var gcse = document.createElement('script');
    gcse.type = 'text/javascript';
    gcse.async = true;
    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
        '//www.google.com/cse/cse.js?cx=' + cx;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(gcse, s);
  })();
</script>
<gcse:search></gcse:search>
-->
            </div>
            <br />
          </div>

            <?php if (PC_Config::get('service_url') == '') : ?>
          <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
            <div class="vote_rank_content">
             <?php //include PUMPCMS_APP_PATH . '/module/shop/view/shop_vote_ranking_block.php'; ?>
            </div>
  <br />
            <div class="vote_rank_content">
             <?php //include PUMPCMS_APP_PATH . '/module/shop/view/sns_button.php'; ?>
            </div>
            <?php endif ; ?>
          </div> <!-- side -->      
        </div> <!-- main_content -->
      </div> <!-- page-header -->
    </div> <!-- container main -->

      <footer>
        <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <ul class="list-unstyled">
              <li class="pull-right"><a href="#top">Back to top</a></li>
              <li><a href="http://news.bootswatch.com" onclick="pageTracker._link(this.href); return false;">Blog</a></li>
              <li><a href="http://feeds.feedburner.com/bootswatch">RSS</a></li>
              <li><a href="https://twitter.com/bootswatch">Twitter</a></li>
              <li><a href="https://github.com/thomaspark/bootswatch/">GitHub</a></li>
              <li><a href="../help/#api">API</a></li>
              <li><a href="../help/#support">Support</a></li>
            </ul>
            
            <p>Made by <a href="http://thomaspark.me" rel="nofollow">Thomas Park</a>. Contact him at <a href="mailto:thomas@bootswatch.com">thomas@bootswatch.com</a>.</p>
            <p>Code released under the <a href="https://github.com/thomaspark/bootswatch/blob/gh-pages/LICENSE">MIT License</a>.</p>
            <p>Based on <a href="http://getbootstrap.com" rel="nofollow">Bootstrap</a>. Icons from <a href="http://fortawesome.github.io/Font-Awesome/" rel="nofollow">Font Awesome</a>. Web fonts from <a href="http://www.google.com/webfonts" rel="nofollow">Google</a>.</p>
          </div>
        </div>
      </footer>


    <!--</div>-->

    <script src="<?php echo SiteInfo::get_css_url() ?>/theme/default/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo SiteInfo::get_css_url() ?>/theme/default/assets/js/bootswatch.js"></script>
    <script src="<?php echo SiteInfo::get_css_url() ?>/js/notify.min.js"></script>
    <script src="<?php echo SiteInfo::get_css_url() ?>/js/notify_func.js"></script>
  </body>
</html>
