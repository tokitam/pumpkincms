<?php if (defined('PUMPCMS_ROOT_PATH') == false) { exit(); } ?><!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title><?php echo PC_Config::get('site_title') ?> | Master Admin</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo SiteInfo::get_css_url() ?>/theme/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo SiteInfo::get_css_url() ?>/theme/admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo SiteInfo::get_css_url() ?>/theme/admin/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?php echo SiteInfo::get_css_url() ?>/theme/admin/css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="<?php echo SiteInfo::get_css_url() ?>/theme/admin/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="<?php echo SiteInfo::get_css_url() ?>/theme/admin/css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?php echo SiteInfo::get_css_url() ?>/theme/admin/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php echo SiteInfo::get_css_url() ?>/theme/admin/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo SiteInfo::get_css_url() ?>/theme/admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <link href="<?php echo SiteInfo::get_css_url(); ?>/css/pumpcms.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <link rel="shortcut icon" type="image/x-icon" href="<?php echo SiteInfo::get_css_url(); ?>/theme/shop/images/favicon.ico" />




        <!-- jQuery 2.0.2 -->
        <!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>-->
        <script src="<?php echo SiteInfo::get_css_url(); ?>/js/jquery-2.1.1.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="<?php echo SiteInfo::get_css_url() ?>/theme/admin/js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="<?php echo SiteInfo::get_css_url() ?>/theme/admin/js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="<?php echo SiteInfo::get_css_url() ?>/theme/admin/js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="<?php echo SiteInfo::get_css_url() ?>/theme/admin/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="<?php echo SiteInfo::get_css_url() ?>/theme/admin/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="<?php echo SiteInfo::get_css_url() ?>/theme/admin/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="<?php echo SiteInfo::get_css_url() ?>/theme/admin/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="<?php echo SiteInfo::get_css_url() ?>/theme/admin/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- datepicker -->
        <script src="<?php echo SiteInfo::get_css_url() ?>/theme/admin/js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="<?php echo SiteInfo::get_css_url() ?>/theme/admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="<?php echo SiteInfo::get_css_url() ?>/theme/admin/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="<?php echo SiteInfo::get_css_url() ?>/theme/admin/js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!--
        <script src="<?php echo SiteInfo::get_css_url() ?>/theme/admin/js/AdminLTE/dashboard.js" type="text/javascript"></script>
        -->

        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <script type="text/javascript" src="<?php echo SiteInfo::get_css_url() ?>/js/pump_gmap.js"></script>
        <script type="text/javascript" src="<?php echo SiteInfo::get_css_url() ?>/js/jquery-2.1.0.min.js"></script>
        <!--
        <script type="text/javascript" src="<?php echo SiteInfo::get_css_url(); ?>/js/jquery.notific8.js"></script>
        <script type="text/javascript" src="<?php echo SiteInfo::get_css_url(); ?>/js/notific8_func.js"></script>
        -->
        <script src="<?php echo SiteInfo::get_css_url(); ?>/js/tinymce/tinymce.min.js"></script>
        <script src="<?php echo SiteInfo::get_css_url(); ?>/js/notify.min.js"></script>
        <script src="<?php echo SiteInfo::get_css_url(); ?>/js/pumpform.js"></script>
    
        <script type="text/javascript">

$(document).ready(function() {

    // google map
    PumpGmapUtil.onload();

    <?php 
    if (PC_Notification::exists()) {
        echo "pc_notification('" . PC_Notification::get() . "');\n";
        PC_Notification::clear();
    }  
    ?>

/*
    // masonry
    var container = document.querySelector('#container');
    var msnry = new Masonry( container, {
      // options
      columnWidth: 300,
      itemSelector: '.masonry_item'
    });
*/

/*
    // Flex Slider
    $('.flexslider').flexslider({
        animation: "slide"
    });
    */
});

tinymce.init({
language : "ja",
plugins: [ "textcolor table link image hr pagebreak ",
    "autolink anchor emoticons code" ],
//toolbar: "forecolor backcolor",
menubar: "file edit view format tools table ",
toolbar1: "core undo redo | bold italic underline strikethrough alignleft aligncenter alignright | autolink link image",
toolbar2: "hr pagebreak | bullist numlist outdent indent | forecolor backcolor fontsizeselect",
image_advtab: true,
selector:'.pump_tinymce'
});


</script>




    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo PC_Config::url() ?>/admin/" class="logo">
                PumpkinCMS
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo UserInfo::get('name') ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <?php /* <img src="<?php echo SiteInfo::get_css_url() ?>/theme/admin/img/avatar3.png" class="img-circle" alt="User Image" /> */ ?>
<?php if (0 < UserInfo::get('image_id')) : ?>
                                    <img src="<?php echo PumpImage::get_url(UserInfo::get('image_id'), 215, 215, array('crop' => 1)) ?>" class="image-circle" />
<?php else : ?>
                                    <img src="<?php echo SiteInfo::get_css_url() ?>/image/no_image.png" class="image-circle" />
<?php endif ; ?>                                    
                                    <p>
                                        <?php echo UserInfo::get('name') ?>
                                        <!-- <small>登録日時 <?php echo strftime('%Y/%m/%d %H:%M', UserInfo::get('reg_time')) ?></small>-->
                                        <small><?php echo _MD_ADMIN_LAST_LOGIN ?> <?php echo strftime('%Y/%m/%d %H:%M', UserInfo::get('last_login_time')) ?></small>
                                    </p>
                                </li>
                                <?php /*
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                */ ?>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo PC_Config::url() ?>/user/" class="btn btn-default btn-flat"><?php echo _MD_ADMIN_PROFILE ?></a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo PC_Config::url() ?>/user/logout" class="btn btn-default btn-flat"><?php echo _MD_ADMIN_LOGOUT ?></a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <?php /*
                        <div class="pull-left image">
                            <img src="<?php echo SiteInfo::get_css_url() ?>/theme/admin/img/avatar3.png" class="img-circle" alt="User Image" />
                        </div>
                        */ ?>
                        <div class="pull-left info">
                            <?php $shop = PC_Config::get('shop'); ?>
                            <a href="<?php echo PC_Config::url(); ?>/">
                                <?php echo htmlspecialchars(PC_Config::get('site_title')) ?>
                            </a>
                        </div>
                    </div>
                    <?php /*
                    <!-- search form -->
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search..."/>
                            <span class="input-group-btn">
                                <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- /.search form -->
                    */ ?>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="<?php echo PC_Config::url() ?>/admin/">
                                <i class="fa fa-dashboard"></i> <span><?php echo _MD_ADMIN_TOP ?></span>
                           </a>
                        </li>
                        <li class="active">
                            <a href="<?php echo PC_Config::url() ?>/admin/config/">
                                <i class="fa fa-edit"></i> <span><?php echo _MD_ADMIN_SETTING ?></span>
                           </a>
                        </li>
                        <li class="active">
                            <a href="<?php echo PC_Config::url() ?>/admin/user/">
                                <i class="fa fa-edit"></i> <span><?php echo _MD_ADMIN_USER ?></span>
                           </a>
                        </li>
                        <li class="active">
                            <a href="<?php echo PC_Config::url() ?>/admin/image/">
                                <i class="fa fa-edit"></i> <span><?php echo _MD_ADMIN_IMAGE ?></span>
                           </a>
                        </li>
                        <li class="active">
                            <a href="<?php echo PC_Config::url() ?>/admin/page/">
                                <i class="fa fa-edit"></i> <span><?php echo _MD_ADMIN_PAGE ?></span>
                           </a>
                        </li>
                        <li class="active">
                            <a href="<?php echo PC_Config::url() ?>/admin/diralias/">
                                <i class="fa fa-edit"></i> <span><?php echo _MD_ADMIN_DIRALIAS ?></span>
                           </a>
                        </li>
<?php

$dir = PUMPCMS_APP_PATH . '/module';
if ($dh = opendir($dir)) {
    while (($file = readdir($dh)) !== false) {
        if ($file == '.' || $file == '..' || $file == 'admin') {
            continue;
        }
        $admin_menu = $dir . '/' . $file . '/admin/menu.php';
        
        if (is_readable($admin_menu)) {
            include $admin_menu;
        }
    }
    closedir($dh);
}

?>
                        <li class="active">
                            <a href="<?php echo PC_Config::url() ?>/admin/blog/">
                                <i class="fa fa-edit"></i> <span><?php echo _MD_ADMIN_BLOG ?></span>
                           </a>
                        </li>
                        <?php if (!empty(PC_Config::get('admin_menu'))) ?>
                        <?php foreach (PC_Config::get('admin_menu') as $menu) : ?>
                        <li class="active">
                            <a href="<?php echo $menu['url'] ?>/">
                                <i class="fa fa-edit"></i> <span><?php echo htmlspecialchars($menu['title']) ?></span>
                           </a>
                        </li>
                        <?php endforeach ; ?>
                        <li class="active">
                            <a href="<?php echo PC_Config::url() ?>/">
                                <i class="fa fa-edit"></i> <span><?php echo _MD_ADMIN_WEBSITE ?></span>
                           </a>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->

                <!-- Main content -->
                <section class="content">

                    <div class="row" style="padding: 15px;">
                        <?php $this->module_render(); ?>
                   </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

        <!-- add new calendar event modal -->


    </body>
</html>