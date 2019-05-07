
-- Дамп структуры базы данных doingsdone
CREATE DATABASE IF NOT EXISTS `doingsdone`
USE `doingsdone`;

-- Дамп структуры для таблица doingsdone.project
CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица doingsdone.task
CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(1) DEFAULT '0' COMMENT 'число (1 или 0), означающее, была ли выполнена задача',
  `title` varchar(1000) NOT NULL COMMENT 'название задачи',
  `file_link` varchar(1000) DEFAULT NULL COMMENT 'ссылка на файл',
  `due_date` date DEFAULT NULL COMMENT 'дата, до которой задача должна быть выполнена',
  `date_create` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.
-- Дамп структуры для таблица doingsdone.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reg_date` datetime DEFAULT NULL COMMENT 'дата регистрации пользователя',
  `email` varchar(100) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Атрибуты пользователей';
