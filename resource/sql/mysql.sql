
CREATE TABLE IF NOT EXISTS `xzqb_admin_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `reg_time` int(11) NOT NULL,
  `mod_time` int(11) NOT NULL,
  `reg_user` int(11) NOT NULL,
  `mod_user` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `xzqb_blog_blog` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`site_id` int(11) NOT NULL,
`reg_time` int(11) NOT NULL,
`mod_time` int(11) NOT NULL,
`reg_user` int(11) NOT NULL,
`mod_user` int(11) NOT NULL,
`blog_id` int(11) NOT NULL DEFAULT '1',
`status` int(11) NOT NULL,
`title` text NOT NULL,
`body` text NOT NULL,
`start_time` int(11) NOT NULL,
`end_time` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `xzqb_fileuptest_fileuptest` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`site_id` int(11) NOT NULL,
`body` text NOT NULL,
`file_id` int(11) NOT NULL,
`movie_url` varchar(256) NOT NULL,
`reg_time` int(11) NOT NULL,
`mod_time` int(11) NOT NULL,
`reg_user` int(11) NOT NULL,
`mod_user` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `xzqb_file_file` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`site_id` int(11) NOT NULL,
`type` int(11) NOT NULL,
`code` varchar(16) NOT NULL,
`public` int(11) NOT NULL,
`ip_address` varchar(16) NOT NULL,
`size` int(11) NOT NULL DEFAULT '0',
`filename` varchar(255) NOT NULL DEFAULT '',
`file` longblob NOT NULL,
`reg_time` int(11) NOT NULL,
`mod_time` int(11) NOT NULL,
`reg_user` int(11) NOT NULL,
`mod_user` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `xzqb_image_image` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`site_id` int(11) NOT NULL,
`width` int(11) NOT NULL,
`height` int(11) NOT NULL,
`type` int(11) NOT NULL,
`code` varchar(16) NOT NULL,
`public` int(11) NOT NULL,
`ip_address` varchar(16) NOT NULL,
`title` varchar(64) NOT NULL DEFAULT '',
`desc` text NOT NULL,
`image` mediumblob NOT NULL,
`reg_time` int(11) NOT NULL,
`mod_time` int(11) NOT NULL,
`reg_user` int(11) NOT NULL,
`mod_user` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `xzqb_page_diralias` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`site_id` int(11) NOT NULL,
`dir` varchar(32) NOT NULL,
`module` varchar(32) NOT NULL,
`reg_time` int(11) NOT NULL,
`mod_time` int(11) NOT NULL,
`reg_user` int(11) NOT NULL,
`mod_user` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `xzqb_page_page` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`site_id` int(11) NOT NULL,
`dir_name` varchar(32) NOT NULL,
`title` varchar(64) NOT NULL,
`body` text NOT NULL,
`last_modified_time` int(11) NOT NULL,
`flg_add_div` int(11) NOT NULL DEFAULT '1',
`reg_time` int(11) NOT NULL,
`mod_time` int(11) NOT NULL,
`reg_user` int(11) NOT NULL,
`mod_user` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `site_is` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `xzqb_simplebbs_simplebbs` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`site_id` int(11) NOT NULL,
`body` text NOT NULL,
`image_id` int(11) NOT NULL,
`movie_url` varchar(256) NOT NULL,
`reg_time` int(11) NOT NULL,
`mod_time` int(11) NOT NULL,
`reg_user` int(11) NOT NULL,
`mod_user` int(11) NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `xzqb_system_config` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`site_id` int(11) NOT NULL,
`reg_time` int(11) NOT NULL,
`mod_time` int(11) NOT NULL,
`reg_user` int(11) NOT NULL,
`mod_user` int(11) NOT NULL,
`shop_id` int(11) NOT NULL,
`status` int(11) NOT NULL,
`title` text NOT NULL,
`body` text NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `xzqb_user_actionlog` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`site_id` int(11) NOT NULL,
`reg_time` int(11) NOT NULL,
`mod_time` int(11) NOT NULL,
`reg_user` int(11) NOT NULL,
`mod_user` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`type` int(11) NOT NULL,
`ip_address` int(11) NOT NULL,
`desc` varchar(255) NOT NULL,
`param1` int(11) NOT NULL DEFAULT '0',
`param2` int(11) NOT NULL DEFAULT '0',
`param3` int(11) NOT NULL DEFAULT '0',
`param4` int(11) NOT NULL DEFAULT '0',
`user_agent` varchar(255) NOT NULL DEFAULT '',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `xzqb_user_remindpass` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`site_id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`code` varchar(32) NOT NULL,
`reg_time` int(11) NOT NULL,
`mod_time` int(11) NOT NULL,
`reg_user` int(11) NOT NULL,
`mod_user` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `site_id` (`site_id`),
KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `xzqb_user_tel_auth` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`site_id` int(11) NOT NULL,
`reg_time` int(11) NOT NULL,
`mod_time` int(11) NOT NULL,
`reg_user` int(11) NOT NULL,
`mod_user` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
`code` varchar(32) NOT NULL,
`flg_fnish` int(11) NOT NULL DEFAULT '0',
`check_string` varchar(32) NOT NULL,
`tel_country` varchar(6) NOT NULL,
`tel_no` varchar(32) NOT NULL,
PRIMARY KEY (`id`),
KEY `site_id` (`site_id`),
KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `xzqb_user_temp` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`site_id` int(11) NOT NULL,
`name` varchar(32) NOT NULL,
`email` varchar(32) NOT NULL,
`password` varchar(32) NOT NULL,
`type` int(11) NOT NULL DEFAULT '0',
`flg_processed` int(11) NOT NULL,
`code` varchar(32) NOT NULL,
`reg_time` int(11) NOT NULL,
`mod_time` int(11) NOT NULL,
`reg_user` int(11) NOT NULL,
`mod_user` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `xzqb_user_user` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`site_id` int(11) NOT NULL,
`name` varchar(32) NOT NULL,
`password` varchar(32) NOT NULL,
`last_login_time` int(11) NOT NULL,
`email` varchar(128) NOT NULL,
`auth` int(11) NOT NULL DEFAULT '0',
`type` int(11) NOT NULL DEFAULT '0',
`image_id` int(11) NOT NULL,
`tel_country` varchar(6) NOT NULL,
`tel_no` varchar(32) NOT NULL,
`flg_tel_auth` int(11) NOT NULL DEFAULT '0',
`vote_disable_time` int(11) NOT NULL DEFAULT '0',
`count_good` int(11) NOT NULL,
`count_bad` int(11) NOT NULL,
`reg_time` int(11) NOT NULL,
`mod_time` int(11) NOT NULL,
`reg_user` int(11) NOT NULL,
`mod_user` int(11) NOT NULL,
PRIMARY KEY (`id`),
KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
