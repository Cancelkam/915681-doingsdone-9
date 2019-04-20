<?php

function elements_count($project_list , $project_title) {
    $sum=0;
    foreach ($project_list as $value){
        if  ($value['category'] === $project_title){
            $sum++;
        }
    }
    return $sum;
}



// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$doings = [
    [
        'title' => 'Собеседование в IT компании',
        'date' => '01.12.2018',
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
        'date' => '21.12.2018',
        'category' => 'Учеба',
        'done' => 'Да'
    ],
    [
        'title' => 'Встреча с другом',
        'date' => '22.12.2018',
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
$page_content = include_template('index.php', ['projects' => $projects, 'doings'=> $doings, 'show_complete_tasks' => $show_complete_tasks]);
$layout_content = include_template('layout.php', ['content' => $page_content,
'title' => 'Дела в порядке','projects' => $projects ,'doings'=> $doings, ]);
print($layout_content);
?>