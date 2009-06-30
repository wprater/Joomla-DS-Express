DROP TABLE IF EXISTS `#__dsexpress_documents`;

CREATE TABLE `#__dsexpress_documents` (
  `id` int(11) NOT NULL auto_increment,
  `greeting` varchar(25) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `#__dsexpress_documents` (`greeting`) VALUES ('Hello, World!'), ('Bonjour, Monde!'), ('Ciao, Mondo!');
