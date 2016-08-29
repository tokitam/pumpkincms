
CREATE TABLE `xzqb_admin_config` (
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

CREATE TABLE `xzqb_blog_blog` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xzqb_file_file` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xzqb_fileuptest_fileuptest` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xzqb_image_image` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xzqb_page_diralias` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xzqb_page_page` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xzqb_simplebbs_simplebbs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `image_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL DEFAULT '0',
  `movie_url` varchar(256) NOT NULL,
  `reg_time` int(11) NOT NULL,
  `mod_time` int(11) NOT NULL,
  `reg_user` int(11) NOT NULL,
  `mod_user` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xzqb_system_config` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xzqb_user_actionlog` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xzqb_user_facebook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `reg_time` int(11) NOT NULL DEFAULT '0',
  `mod_time` int(11) NOT NULL DEFAULT '0',
  `reg_user` int(11) NOT NULL DEFAULT '0',
  `mod_user` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `facebook_id` bigint(20) NOT NULL,
  `email` varchar(64) NOT NULL,
  `name` varchar(64) NOT NULL,
  `link` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `user_id` (`user_id`),
  KEY `facebook_id` (`facebook_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xzqb_user_remindpass` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xzqb_user_tel_auth` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xzqb_user_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `flg_processed` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `reg_time` int(11) NOT NULL,
  `mod_time` int(11) NOT NULL,
  `reg_user` int(11) NOT NULL,
  `mod_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xzqb_user_twitter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `reg_time` int(11) NOT NULL DEFAULT '0',
  `mod_time` int(11) NOT NULL DEFAULT '0',
  `reg_user` int(11) NOT NULL DEFAULT '0',
  `mod_user` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `access_token` varchar(64) NOT NULL,
  `access_token_secret` varchar(64) NOT NULL,
  `twitter_id` bigint(20) NOT NULL,
  `screen_name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `user_id` (`user_id`),
  KEY `twitter_id` (`twitter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `xzqb_user_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `display_name` varchar(32) NOT NULL DEFAULT '',
  `profile` varchar(200) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL,
  `last_login_time` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `xzqb_user_user_rel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `reg_time` int(11) NOT NULL,
  `mod_time` int(11) NOT NULL,
  `reg_user` int(11) NOT NULL,
  `mod_user` int(11) NOT NULL,
  `user_id1` int(11) NOT NULL,
  `user_id2` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
