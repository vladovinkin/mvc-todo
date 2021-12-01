CREATE TABLE if not exists `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `login` varchar(64) NOT NULL,
  `hash` varchar(256) NOT NULL,
  `name` varchar(64) NOT NULL,
  `surname` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;