CREATE DATABASE Store;
USE Store;

DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(3072) NOT NULL,
  `price` varchar(3072) NOT NULL,
  `image` varchar(3072) NOT NULL,
  `weight` varchar(3072) NOT NULL,
  `stock` varchar(3072) NOT NULL,
  `category` varchar(3072) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `tabs`;
CREATE TABLE `tabs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tabs` varchar(3072) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tabs` (`tabs`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;