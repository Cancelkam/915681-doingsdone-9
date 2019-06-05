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

}

if (isset($_GET['check']) && isset($_GET['task_id'])) {

    $check=(int) $_GET['check'];
    $task_id=(int) $_GET['task_id'];
    $sql = 'UPDATE tasks SET status = ' . $check . ' WHERE id=' . $task_id . ' AND user_id=' . $user_id;
    $result = mysqli_query($con, $sql);
    test_result($result, $sql);
}

// if (isset($_GET['filter'])) {
    switch ($_GET['filter']){
        case 'day':
            $sql='SELECT title, status AS done, due_date AS date, file_link, id FROM tasks WHERE ' . ( $is_project_isset ? 'project_id =' . $project_id . ' AND ': "" ) . 'user_id =' . $user_id . ' AND due_date=CURDATE()';
            break;
        case 'tomorrow':
            $sql = 'SELECT title, status AS done, due_date AS date, file_link, id FROM tasks WHERE ' . ( $is_project_isset ? 'project_id =' . $project_id . ' AND ': "" ) . 'user_id =' . $user_id . ' AND due_date = CURDATE() + INTERVAL 1 DAY';
            break;
        case 'overdue':
            $sql = 'SELECT title, status AS done, due_date AS date, file_link, id FROM tasks WHERE ' . ( $is_project_isset ? 'project_id =' . $project_id . ' AND ': "" ) . 'user_id =' . $user_id . ' AND due_date < CURDATE()';
            break;
        default:
            $sql='SELECT title, status AS done, due_date AS date, file_link, id FROM tasks WHERE ' . ( $is_project_isset ? 'project_id =' . $project_id . ' AND ': "" ) . 'user_id =' . $user_id;
    }
// }



// $sql = 'SELECT title, status AS done, due_date AS date, file_link, id FROM tasks WHERE ' . ( $is_project_isset ? 'project_id =' . $project_id . ' AND ': "" ) . 'user_id =' . $user_id;
$result = mysqli_query($con, $sql);
test_result($result, $sql);
$tasks_list = mysqli_fetch_all($result,MYSQLI_ASSOC);

$param = $_GET;
unset($param['filter']);
$url = '/' . pathinfo(__FILE__,PATHINFO_BASENAME) . "?" . http_build_query($param);


$page_content = include_template('index.php',[
'projects' => $projects_list,
'doings'=> $tasks_list,
'show_complete_tasks' => $show_complete_tasks,
'url' => $url
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
