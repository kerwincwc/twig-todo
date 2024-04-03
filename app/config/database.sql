-- Adminer 4.8.1 MySQL 5.5.5-10.4.10-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE IF NOT EXISTS 'testdb' ;
USE 'testdb';
DROP TABLE IF EXISTS `twig_todo`;
CREATE TABLE `twig_todo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task` varchar(1024) NOT NULL,
  `completed` tinyint(4) NOT NULL DEFAULT 0,
  `added` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- 2024-03-29 20:04:38
