<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>PumpkinCMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="stylesheet" href="http://127.0.0.1/pumpcms/public/themes/default/bootstrap.css" media="screen">
    <link rel="stylesheet" href="http://127.0.0.1/pumpcms/public/themes/default/assets/css/bootswatch.css">
    <link rel="stylesheet" href="http://127.0.0.1/pumpcms/public/themes/default/custom.css">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../bower_components/html5shiv/dist/html5shiv.js"></script>
      <script src="../bower_components/respond/dest/respond.min.js"></script>
    <![endif]-->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>

    <script type="text/javascript">

    $(document).ready(function() {
      
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
    
  <body style='background-image: url("http://127.0.0.1/pumpcms/public/themes/default/pattern8-pattern-26b.png");'>
  
    <div class="container">
      <div class="page-header" id="banner">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 main_content">
            
<div class="twelve columns">
<p>

        <div class="row">


          <div class="col-lg-12">
            <!--<div class="well bs-component">-->
              <form class="form-horizontal" method="post" action="<?php echo PC_Config::url() ?>/user/login">
              	<input type="hidden" name="login" value="1">
                <fieldset>
                  <legend><?php echo htmlspecialchars(PC_Config::get('site_title')) ?></legend>
                  <?php echo PC_Config::get('site_close_message') ?>
                  <div class="form-group">
                    <label for="inputEmail" class="col-lg-3 control-label"><?php echo _MD_LOGIN_EMAIL ?></label>
                    <div class="col-lg-9">
                      <input required type="email" class="form-control" id="inputEmail" placeholder="Email" name="email" value="">
                                          </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword" class="col-lg-3 control-label"><?php echo _MD_PASSWORD ?></label>
                    <div class="col-lg-9">
                    	<input required type="password" class="form-control" id="inputPassword" placeholder="Password" name="password"><br />
                    	<?php echo _MD_USER_SITE_CLOSE_INFO ?>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputPassword" class="col-lg-3 control-label">&nbsp;</label>
                    <div class="col-lg-9">
                      <button type="submit" class="btn btn-primary"><?php echo _MD_USER_LOGIN ?></button>

                      <!--
                    	<input required type="password" class="form-control" id="inputPassword" placeholder="Password" name="password"><br />
                    	<?php echo _MD_USER_SITE_CLOSE_INFO ?>
                    -->
                    </div>
                  </div>
                  <!--
                  <div class="form-group">
                  	<labe for="inputEmail"class="col-lg-3 control-label">&nbsp;</label>
                    <div class="col-lg-9">
                      <button type="submit" class="btn btn-primary"><?php echo _MD_USER_LOGIN ?></button>
                    </div>
                  </div>
              		-->
                </fieldset>
              </form>
            <!--</div>-->
          </div> <!-- end col-lg-12 -->
        </div> <!-- end row -->
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />


</P>
</div>

  
          </div>
          <div class="col-xs-4 col-sm-4 visible-xs visible-sm invisible-md invisible-lg ">
    <br />
          </div>

          <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

            <p>
                                    </p>
            <br />

            <div class="vote_rank_content">

            </div>
            <br />
          </div>

                      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
            <div class="vote_rank_content">
                         </div>
  <br />
            <div class="vote_rank_content">
                         </div>
                      </div> <!-- side -->      
        </div> <!-- main_content -->
      </div> <!-- page-header -->
    </div> <!-- container main -->

    <!--</div>-->

    <script src="http://127.0.0.1/pumpcms/public/themes/default/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="http://127.0.0.1/pumpcms/public/themes/default/assets/js/bootswatch.js"></script>
    <script src="http://127.0.0.1/pumpcms/public/js/notify.min.js"></script>
    <script src="http://127.0.0.1/pumpcms/public/js/notify_func.js"></script>
  </body>
</html>
