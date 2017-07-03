            <div class="four columns" id="cssmenu">
                <!-- <h3>menu</h3> -->
                <p>

<!--
<ul>
   <li class='active'><a href='index.html'><span>Home</span></a></li>
   <li><a href='#'><span>Products</span></a></li>
   <li><a href='#'><span>About</span></a></li>
   <li class='last'><a href='#'><span>Contact</span></a></li>
</ul>
-->


                    <ul>
<?php if (UserInfo::is_admin_mode()) : ?>
                        <li><a href="<?php echo PC_Config::get('base_url') ?>/admin/user/"><span>user manage</span></a></li>
                        <li><a href="<?php echo PC_Config::get('base_url') ?>/admin/page/"><span>page manage</span></a></li>
                        <li><a href="<?php echo PC_Config::get('base_url') ?>/admin/diralias/"><span>diralias manage</span></a></li>
                        <li><a href="<?php echo PC_Config::get('base_url') ?>/admin/shop/"><span>shop manage</span></a></li>
                        <li><a href="<?php echo PC_Config::get('base_url') ?>/admin/ad/"><span>ad manage</span></a></li>
                        <li><a href="<?php echo PC_Config::get('base_url') ?>/admin/image/"><span>image manage</span></a></li>
                        <li><a href="<?php echo PC_Config::get('base_url') ?>/"><span>to website</span></a></li>
    <?php if (UserInfo::is_master_admin()) : ?>

    <?php endif ; ?>    
<?php else : ?>    
                        <li><a href="<?php echo PC_Config::get('base_url') ?>/"><span>ホーム</span></a></li>
                        <li><a href="<?php echo PC_Config::get('base_url') ?>/offer"><span>オファー</span></a></li>
                        <li><a href="<?php echo PC_Config::get('base_url') ?>/simplebbs/"><span>simplebbs</span></a></li>
                        <li><a href="<?php echo PC_Config::get('base_url') ?>/blog/"><span>blog</span></a></li>
                        <li><a href="<?php echo PC_Config::get('base_url') ?>/user/"><span>ユーザ</span></a></li>
    <?php if (UserInfo::is_site_admin()) : ?>
                        <!--<li>---</li> -->
                        <li><a href="<?php echo PC_Config::get('base_url') ?>/admin/"><span>管理者モード</span></a></li>
                        <!-- <li>---</li> -->
    <?php endif ; ?>    
<?php endif ; ?>    

                    </ul>
<!--
    <a href="<?php echo PC_Config::get('base_url') ?>/?pump_lang=english"><img src="<?php echo PC_Config::get('base_url') ?>/image/english.gif" alt="ENGLISH"></a>
    <a href="<?php echo PC_Config::get('base_url') ?>/?pump_lang=japanese"><img src="<?php echo PC_Config::get('base_url') ?>/image/japanese.gif" alt="JAPANESE"></a>
-->
                </p>
            </div>

