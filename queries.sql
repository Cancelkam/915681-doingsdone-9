
-- Дамп данных таблицы doingsdone.projects: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` (`id`, `project_name`, `user_id`) VALUES
	(1, 'Входящие', '2'),
	(2, 'Учеба', '2'),
	(3, 'Работа', '1'),
	(4, 'Домашние дела', '2'),
	(5, 'Авто', NULL);
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;

-- Дамп данных таблицы doingsdone.tasks: ~7 rows (приблизительно)
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` (`id`, `status`, `title`, `file_link`, `due_date`, `date_create`, `user_id`, `project_id`) VALUES
	(1, 1, 'Собеседование в IT компании', NULL, '2019-01-12', '2019-05-08 22:09:23', 1, 3),
	(2, 0, 'Выполнить тестовое задание', NULL, '2018-12-21', '2019-05-08 22:11:16', 1, 3),
	(3, 1, 'Сделать задание первого раздела', NULL, '2019-12-21', '2019-05-08 22:12:05', 1, 2),
	(4, 0, 'Встреча с другом', NULL, '2019-12-22', '2019-05-08 22:17:55', 2, 1),
	(5, 0, 'Купить корм для кота', NULL, NULL, '2019-05-08 22:18:37', 2, 4),
	(6, 0, 'Заказать 2 пиццы', NULL, NULL, '2019-05-08 22:18:52', 2, 4);
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;

-- Дамп данных таблицы doingsdone.users: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `reg_date`, `email`, `name`, `password`) VALUES
	(1, '2019-05-08 23:28:14', '111@ya.ru', 'Andrey', '123123'),
	(2, '2019-05-08 23:28:43', '222@ya.ru', 'Alyona', '321321');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

SELECT project_name FROM project JOIN user ON user_id=2 /*получить список из всех проектов для одного пользователя*/
SELECT COUNT(1) FROM task WHERE project_id=3 /*посчитать количество задач в каждом проекте*/
SELECT title FROM tasks WHERE project_id=1 /*получить список из всех задач для одного проекта*/
UPDATE doingsdone.tasks SET status=1 WHERE id=1; /*пометить задачу как выполненную*/
UPDATE doingsdone.tasks SET title='Заказать 3 пиццы' WHERE id=6; /*обновить название задачи по её идентификатору*/