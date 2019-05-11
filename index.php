<?php

require_once('functions.php');
require_once('helpers.php');
$show_complete_tasks = 1;
$con=mysqli_connect('localhost','root','','doingsdone');
if ($con===false){
    print("Ошибка подключения:" . mysqli_connect_error());
}
else {
    print("Соединение установлено");
}
mysqli_set_charset($con,"utf8");


$sql_projects_list =
"SELECT projects.project_name, COUNT(*) AS task_count FROM projects
JOIN tasks ON projects.id = tasks.project_id
WHERE tasks.user_id=2
GROUP BY tasks.project_id;";

$result_projects_list = mysqli_query($con,$sql_projects_list);
$projects_list = mysqli_fetch_all($result_projects_list);

$sql_tasks_list = "SELECT title,status,due_date FROM tasks WHERE user_id=2";
$result_tasks_list = mysqli_query($con,$sql_tasks_list);
$tasks_list = mysqli_fetch_all($result_tasks_list);

$page_content = include_template('index.php', ['projects' => $projects_list,
                                               'doings'=> $tasks_list,
                                               'show_complete_tasks' => $show_complete_tasks]);
$layout_content = include_template('layout.php', ['content' => $page_content,
                                                  'title' => 'Дела в порядке',
                                                  'projects' => $projects_list,
                                                  'doings'=> $tasks_list, ]);
print($layout_content);