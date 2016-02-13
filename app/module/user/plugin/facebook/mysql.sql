
CREATE TABLE IF NOT EXISTS `xzqb_user_facebook` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

