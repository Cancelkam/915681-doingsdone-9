<?php

require_once('functions.php');
require_once('helpers.php');
$show_complete_tasks = 1;
$con=mysqli_connect('localhost','root','','doingsdone');
mysqli_set_charset($con,"utf8");

session_start();

if (isset($_SESSION['user']['id'])) {
    $user_id = $_SESSION['user']['id'];
    $user_name =  $_SESSION['user']['name'];
}
 else {
     $user_id = 0;
 }



$projects_list = get_project_list($user_id);

/**
 * Проверка наличия параметра в массиве
 */
$is_project_isset = false;
if (isset($_GET['project_id'])) {
    $project_id= (int) $_GET['project_id'];
    foreach ($projects_list as $project) {
        if ((int) $project['project_id'] === $project_id) {
            $is_project_isset = true;
        }
    }
    if (! $is_project_isset) {
        header("HTTP/1.1 404 Not Found");
        die();
    }
    // Получит список задач по конкретному проекту

}

$sql = 'SELECT title, status AS done, due_date AS date, file_link FROM tasks WHERE ' . ( $is_project_isset ? 'project_id =' . $project_id . ' AND ': "" ) . 'user_id =' . $user_id;
$result = mysqli_query($con, $sql);
test_result($result, $sql);
$tasks_list = mysqli_fetch_all($result,MYSQLI_ASSOC);

$page_content = include_template('index.php',[
'projects' => $projects_list,
'doings'=> $tasks_list,
'show_complete_tasks' => $show_complete_tasks
]);

$layout_content = include_template('layout.php', [
'content' => $page_content,
'title' => 'Дела в порядке',
'projects' => $projects_list,
'doings'=> $tasks_list,
'user' => $user_id,
'user_name' => $user_name
]);

print($layout_content);
