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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
	
	var base_url = '<?php echo PC_Config::url(); ?>';

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
<?php if (PC_Config::get('use_direct_message')) : ?>
            <li class="nav-item visible-xs visible-sm visible-md visible-lg">
              <a class="nav-link " style="padding-bottom: 0px;" data-caret="false" role="button" aria-haspopup="false" aria-expanded="false" data-toggle="modal" onclick="$('#myModal').modal('show');"><i class="material-icons email">mail_outline</i><span class="pumpkin-notification-badge" id="pumpkin-notification-badge"><?php echo PC_Config::get('num_of_dm') ?></span></a>
            </li>
<?php endif ; ?>
<?php if (UserInfo::is_master_admin()) : ?>
            <li>
              <a href="<?php echo PC_Config::url() ?>/admin/"><?php echo _MD_USER_MASTER_ADMIN ?></a>
            </li>
<?php endif ;  ?>
<?php if (UserInfo::is_admin_switch()) : ?>
            <li>
              <a href="<?php echo PC_Config::url() ?>/user/admin_switch"><?php echo _MD_USER_MASTER_ADMIN_SWITCH ?></a>
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

    <!-- Modal -->
    <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel"><?php echo _MD_MESSAE_TITLE ?></h4>
          </div>
          <div class="modal-body">
          <ul class="list-group list-group-fit">
        
        <li class="list-group-item" style="background-color: #EEE;">
          <div class="media">
            <div class="media-left media-middle hidden-sm-down">
              <a class="user-dialog-link">
              <img src="http://sesxion.com/image/i/29_6gacf4jx_300x300_c.jpg" alt="" class="img-circle" width="40" targetid="3">
              </a>
            </div>
            <div class="media-body media-middle">
              <h4 class="card-title m-b-0"><a class="comment-author user-dialog-link"><span targetid="3">toipu</span></a><span class="hidden-sm-down"> <small> | 2018/12/27 14:32 | aaa</small></span> </h4>
              <!--
              <small> <span class="text-muted">created</span>: 4 days ago</small>
              <small class="m-l-1">
                <span class="text-muted">by</span>: <a href="#">Andrew Brain</a>
              </small>
              -->
            </div>
            <div class="media-right media-middle right">
              <div class="text-muted center">
                <a type="button" class="btn btn-primary btn-rounded sesxion-member-kick" href="http://sesxion.com/dm/?u=toipu" authflg="1">メッセージ</a>
              </div>

            </div>
          </div>
        </li>
      
        <li class="list-group-item" style="background-color: #EEE;">
          <div class="media">
            <div class="media-left media-middle hidden-sm-down">
              <a class="user-dialog-link">
              <img src="http://sesxion.com/image/i/11_j6j00pvk_300x300_c.jpg" alt="" class="img-circle" width="40" targetid="147">
              </a>
            </div>
            <div class="media-body media-middle">
              <h4 class="card-title m-b-0"><a class="comment-author user-dialog-link"><span targetid="147">inajey</span></a><span class="hidden-sm-down"> <small> | 2017/09/25 10:07 | セッションへ招待されました！ http:...</small></span> </h4>
              <!--
              <small> <span class="text-muted">created</span>: 4 days ago</small>
              <small class="m-l-1">
                <span class="text-muted">by</span>: <a href="#">Andrew Brain</a>
              </small>
              -->
            </div>
            <div class="media-right media-middle right">
              <div class="text-muted center">
                <a type="button" class="btn btn-primary btn-rounded sesxion-member-kick" href="http://sesxion.com/dm/?u=inajey" authflg="1">メッセージ</a>
              </div>

            </div>
          </div>
        </li>
      
        <li class="list-group-item" style="background-color: #EEE;">
          <div class="media">
            <div class="media-left media-middle hidden-sm-down">
              <a class="user-dialog-link">
              <img src="http://sesxion.com/image/i/45_z1127k6j_300x300_c.jpg" alt="" class="img-circle" width="40" targetid="5">
              </a>
            </div>
            <div class="media-body media-middle">
              <h4 class="card-title m-b-0"><a class="comment-author user-dialog-link"><span targetid="5">tokitafb</span></a><span class="hidden-sm-down"> <small> | 2016/08/01 07:59 | gっっt</small></span> </h4>
              <!--
              <small> <span class="text-muted">created</span>: 4 days ago</small>
              <small class="m-l-1">
                <span class="text-muted">by</span>: <a href="#">Andrew Brain</a>
              </small>
              -->
            </div>
            <div class="media-right media-middle right">
              <div class="text-muted center">
                <a type="button" class="btn btn-primary btn-rounded sesxion-member-kick" href="http://sesxion.com/dm/?u=tokitafb" authflg="1">メッセージ</a>
              </div>

            </div>
          </div>
        </li>
      </ul>
          </div>
          <!--
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
          -->
        </div>
      </div>
    </div>

    <script src="<?php echo SiteInfo::get_css_url() ?>/theme/default/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?php echo SiteInfo::get_css_url() ?>/theme/default/assets/js/bootswatch.js"></script>
    <script src="<?php echo SiteInfo::get_css_url() ?>/js/notify.min.js"></script>
    <script src="<?php echo SiteInfo::get_css_url() ?>/js/pumpform.js?t=<?php echo time() ?>"></script>
    <script src="<?php echo SiteInfo::get_css_url() ?>/js/user_module.js"></script>
  </body>
</html>
