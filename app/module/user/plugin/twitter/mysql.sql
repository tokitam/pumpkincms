
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

  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

