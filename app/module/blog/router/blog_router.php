<?php

require_once PUMPCMS_APP_PATH . '/module/blog/class/blogdefine.php';

class blog_router {
    static function router($service_url) {
        if (preg_match('@^blog/index/feed2widget@', $service_url, $r)) {
            return array('module' => 'blog', 
                'controller' => 'index', 
                'method' => 'feed2widget');
        }
        
        if (preg_match('@^admin/?@', $service_url)) {
            $url = PC_Config::url() . '/admin/blog';
            SiteInfo::add_admin_menu('ブログ管理', $url);

            if (preg_match('@admin/blog/?@', $service_url)) {
                preg_match('@admin/blog/([_A-Za-z]+)/?@', $service_url, $r);
                PumpForm::$scaffold_base_url = PC_Config::url() . '/admin/blog';
                if (isset($r[1])) {
                    $method = $r[1];
                } else {
                    $method = 'index';
                }
                return array(
                    'theme' => 'admin',
                    'module' => 'blog',
                    'controller' => 'blog', 
                    'method' => $method);
            }

            return;
        }

        $blog = PC_Config::get('blog');

        foreach ($blog as $key => $b) {
            $dir = $b['dir'];
            if (preg_match('@^' . $dir . '/(\d+)@', $service_url, $r)) {
                PumpForm::$target_id = intval($r[1]);
                PC_Config::set('blog_dir', $dir);
                PC_Config::set('blog_id', $key);
                PC_Config::set('blog_title', $b['title']);
                return array('module' => 'blog', 
                    'controller' => 'index', 
                    'method' => 'detail');
            }
        }
        
        foreach ($blog as $key => $b) {
            $dir = $b['dir'];
            if (preg_match('@^' . $dir . '@', $service_url)) {
                PC_Config::set('blog_dir', $dir);
                PC_Config::set('blog_id', $key);
                PC_Config::set('blog_title', $b['title']);
                return array('module' => 'blog', 
                    'controller' => 'index', 
                    'method' => 'index');
            }
        }

        return null;
    }
}
