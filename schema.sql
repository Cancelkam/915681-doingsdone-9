
CREATE DATABASE IF NOT EXISTS `doingsdone`;
USE `doingsdone`;

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(50) DEFAULT NULL,
  `user_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`project_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) DEFAULT '0' COMMENT 'число (1 или 0), означающее, была ли выполнена задача',
  `title` varchar(1000) NOT NULL COMMENT 'название задачи',
  `file_link` varchar(1000) DEFAULT NULL COMMENT 'ссылка на файл',
  `due_date` date DEFAULT NULL COMMENT 'дата, до которой задача должна быть выполнена',
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`),
  FULLTEXT KEY `title_search` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reg_date` datetime DEFAULT NULL COMMENT 'дата регистрации пользователя',
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Атрибуты пользователей';
