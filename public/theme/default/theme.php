<?php if (defined('PUMPCMS_ROOT_PATH') == false) { exit(); } ?><!DOCTYPE html>
<!----
                                                                                  
,------.                          ,--.    ,--.         ,-----.,--.   ,--. ,---.   
|  .--. ',--.,--.,--,--,--. ,---. |  |,-. `--',--,--, '  .--./|   `.'   |'   .-'  
|  '--' ||  ||  ||        || .-. ||     / ,--.|      \|  |    |  |'.'|  |`.  `-.  
|  | --' '  ''  '|  |  |  || '-' '|  \  \ |  ||  ||  |'  '--'\|  |   |  |.-'    | 
`--'      `----' `--`--`--'|  |-' `--'`--'`--'`--''--' `-----'`--'   `--'`-----'  
                           `--'                                                   
---->                           
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
    <?php if (!empty($this)) { echo $this->get_header(); } ?>
  </head>
  <!-- <body> -->
<?php if (PC_Config::get('bg_image_url')) : ?>  
  <body style='background-image: url("<?php echo PC_Config::get('bg_image_url') ?>"); background-repeat: repeat;'>
<?php else : ?>    
  <body>
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
            <?php if (PC_Config::get('allow_register')) : ?>
            <li>
              <a href="<?php echo PC_Config::url() ?>/user/register"><?php echo _MD_PUMPFORM_SIGNUP ?></a>
            </li>                    
            <?php endif ; ?>
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
            <?php if (isset($this)) : ?>
            <?php $this->module_render(); ?>  
            <?php else : ?>
            <?php echo @$error_message; ?>
            <?php endif ; ?>
          </div>
          <div class="col-xs-4 col-sm-4 visible-xs visible-sm invisible-md invisible-lg ">
    <br />
          </div>

          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <!-- site content here -->
          </div>

          <!-- side -->      
        </div> <!-- main_content -->
      </div> <!-- page-header -->
    </div> <!-- container main -->

      <footer>
        <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <ul class="list-unstyled">
              <li class="pull-right"><a href="#top">Back to top</a></li>
            </ul>

            <p><a href="http://pumpkincms.com/">PumpkinCMS</a> Lightweight CMS</p>
            <p>&nbsp;</p>
            <p>&copy; 2015 <a href="https://github.com/tokitam">tokitam</a></p>
          </div>
        </div>
        </div>
      </footer>

    <script src="<?php echo SiteInfo::get_css_url() ?>/theme/default/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo SiteInfo::get_css_url() ?>/theme/default/assets/js/bootswatch.js"></script>
    <script src="<?php echo SiteInfo::get_css_url() ?>/js/notify.min.js"></script>
    <script src="<?php echo SiteInfo::get_css_url() ?>/js/pumpform.js?t=<?php echo time() ?>"></script>
    <script src="<?php echo SiteInfo::get_css_url() ?>/js/user_module.js"></script>
  </body>
</html>
