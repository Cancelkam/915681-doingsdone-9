
USE doingsdone;
INSERT INTO `projects` (`id`, `project_name`, `user_id`) VALUES
	(1, 'Входящие', '2'),
	(2, 'Учеба', '2'),
	(3, 'Работа', '1'),
	(4, 'Домашние дела', '2'),
	(5, 'Авто', NULL);

INSERT INTO `tasks` (`id`, `status`, `title`, `file_link`, `due_date`, `date_create`, `user_id`, `project_id`) VALUES
	(1, 1, 'Собеседование в IT компании', NULL, '2019-01-12', '2019-05-08 22:09:23', 1, 3),
	(2, 0, 'Выполнить тестовое задание', NULL, '2018-12-21', '2019-05-08 22:11:16', 1, 3),
	(3, 1, 'Сделать задание первого раздела', NULL, '2019-12-21', '2019-05-08 22:12:05', 1, 2),
	(4, 0, 'Встреча с другом', NULL, '2019-12-22', '2019-05-08 22:17:55', 2, 1),
	(5, 0, 'Купить корм для кота', NULL, NULL, '2019-05-08 22:18:37', 2, 4),
	(6, 0, 'Заказать 2 пиццы', NULL, NULL, '2019-05-08 22:18:52', 2, 4);


INSERT INTO `users` (`id`, `reg_date`, `email`, `name`, `password`) VALUES
	(1, '2019-05-08 23:28:14', '111@ya.ru', 'Andrey', '123123'),
	(2, '2019-05-08 23:28:43', '222@ya.ru', 'Alyona', '321321');

/*получить список из всех проектов для одного пользователя*/
/*посчитать количество задач в каждом проекте*/
SELECT projects.project_name, COUNT(*) AS task_count FROM projects
JOIN tasks ON projects.id = tasks.project_id
WHERE tasks.user_id=1
GROUP BY tasks.project_id;

/*получить список из всех задач для одного проекта*/
SELECT title
FROM tasks
WHERE project_id=1

/*пометить задачу как выполненную*/
UPDATE doingsdone.tasks
SET status=1
WHERE id=1;

/*обновить название задачи по её идентификатору*/
UPDATE doingsdone.tasks
SET title='Заказать 3 пиццы'
WHERE id=6;