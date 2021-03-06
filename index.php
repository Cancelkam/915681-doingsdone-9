<?php
require_once('functions.php');
require_once('helpers.php');
require_once('init.php');

if (isset($_SESSION['user']['id'])) {
    $user_id = $_SESSION['user']['id'];
    $user_name =  $_SESSION['user']['name'];
}
 else {
     $user_id = 0;
 }

$projects_list = get_project_list($user_id);

$is_project_isset = false;
if (isset($_GET['project_id'])) {
    $project_id= (int) $_GET['project_id'];
    foreach ($projects_list as $project) {
        if ((int) $project['project_id'] === $project_id) {
            $is_project_isset = true;
            break;
        }
    }
    if (! $is_project_isset) {
        header("HTTP/1.1 404 Not Found");
        die();
    }

}
if ($_GET['show_completed'] === '1') {
    $show_complete_tasks = 1;
}
else {
    $show_complete_tasks = 0;
}
if (isset($_GET['check']) && isset($_GET['task_id'])) {
    $check=(int) $_GET['check'];
    $task_id=(int) $_GET['task_id'];
    $sql = 'UPDATE tasks SET status = ' . $check . ' WHERE id=' . $task_id . ' AND user_id=' . $user_id;
    $result = mysqli_query($con, $sql);
    test_result($result, $sql);
}
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
$filter=$_GET['filter'] ?? 'all';

$result = mysqli_query($con, $sql);
test_result($result, $sql);
$tasks_list = mysqli_fetch_all($result,MYSQLI_ASSOC);

$param = $_GET;
unset($param['filter']);
$url = '/' . pathinfo(__FILE__,PATHINFO_BASENAME) . "?" . http_build_query($param);

$search = $_GET['search'] ?? '';

if ($search) {
    $sql='SELECT * FROM tasks WHERE MATCH (title) AGAINST (?) AND user_id=' . $user_id;
    $stmt = db_get_prepare_stmt($con, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $task = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $page_content = include_template('search.php',['result'=>$task]);
} else {
    $page_content = include_template('index.php',[
    'projects' => $projects_list,
    'doings'=> $tasks_list,
    'show_complete_tasks' => $show_complete_tasks,
    'url' => $url,
    'filter' => $filter
    ]);
}

$layout_content = include_template('layout.php', [
'content' => $page_content,
'title' => 'Дела в порядке',
'projects' => $projects_list,
'doings'=> $tasks_list,
'user' => $user_id,
'user_name' => $user_name
]);

print($layout_content);
