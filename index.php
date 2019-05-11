<?php
require_once('functions.php');

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$doings = [
    [
        'title' => 'Собеседование в IT компании',
        'date' => '01.12.2019',
        'category' => 'Работа',
        'done' => 'Нет'
    ],
    [
        'title' => 'Выполнить тестовое задание',
        'date' => '21.12.2018',
        'category' => 'Работа',
        'done' => 'Нет'
    ],
    [
        'title' => 'Сделать задание первого раздела',
        'date' => '21.12.2019',
        'category' => 'Учеба',
        'done' => 'Да'
    ],
    [
        'title' => 'Встреча с другом',
        'date' => '22.12.2019',
        'category' => 'Входящие',
        'done' => 'Нет'
    ],
    [
        'title' => 'Купить корм для кота',
        'date' => 'Нет',
        'category' => 'Домашние дела',
        'done' => 'Нет'
    ],
    [
        'title' => 'Заказать пиццу',
        'date' => 'Нет',
        'category' => 'Домашние дела',
        'done' => 'Нет'
    ]
];

$projects = ['Входящие', 'Учеба', 'Работа', 'Домашние дела', 'Авто'];
require_once('helpers.php');
$page_content = include_template('index.php', ['projects' => $projects,
                                               'doings'=> $doings,
                                               'show_complete_tasks' => $show_complete_tasks]);
$layout_content = include_template('layout.php', ['content' => $page_content,
                                                  'title' => 'Дела в порядке',
                                                  'projects' => $projects ,
                                                  'doings'=> $doings, ]);
print($layout_content);


$con=mysqli_connect('localhost','root','','doingsdone');
mysqli_set_charset($con,"utf8");
$sql_projects_list = "SELECT projects.project_name FROM projects WHERE user_id=$current_user_id";
$result_projects_list = mysqli_query($con,$sql_projects_list);
$sql_tasks_list = "SELECT tasks.title FROM tasks WHERE user_id=$current_user_id";
$result_tasks_list = mysqli_query($con,$sql_tasks_list);