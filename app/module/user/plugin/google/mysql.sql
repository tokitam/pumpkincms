
CREATE TABLE IF NOT EXISTS `xzqb_user_google` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(11) NOT NULL,
  `reg_time` int(11) NOT NULL DEFAULT '0',
  `mod_time` int(11) NOT NULL DEFAULT '0',
  `reg_user` int(11) NOT NULL DEFAULT '0',
  `mod_user` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `google_id` varchar(512) NOT NULL,
  `access_token` varchar(256) NOT NULL DEFAULT '',
  `name` varchar(128) NOT NULL DEFAULT '',
  `given_name` varchar(128) NOT NULL DEFAULT '',
  `family_name` varchar(128) NOT NULL DEFAULT '',
  `link` varchar(256) NOT NULL DEFAULT '',
  `picture` varchar(256) NOT NULL DEFAULT '',
  `gender` varchar(16) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

