<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');

if (isset($_SESSION['user']['id'])) {
    $user_id = $_SESSION['user']['id'];
    $user_name =  $_SESSION['user']['name'];
}
else {
    $user_id = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project = $_POST;
    $errors = [];

    if (empty($_POST['name'])){
        $errors['project'] = 'Поле не заполнено!';
    }

    foreach (get_project_list($user_id) as $value) {
        if (trim(mb_strtoupper($_POST['name'])) === trim(mb_strtoupper($value['name']))) {
            $errors['project'] = 'Задача уже существует!';
        }
    }

    if ($errors === []){
        $sql_insert_project = "INSERT INTO projects (project_name , user_id) VALUES ('" . trim($project['name']) . "',$user_id);";
        $result = mysqli_query($con,$sql_insert_project);
    }
}

$page_content = include_template('add_project.php',[
    'project' => $project,
    'errors' => $errors
 ]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Добавление задачи',
    'projects' => get_project_list($user_id),
    'user' => $user_id,
    'user_name' => $user_name
    ]);

    print($layout_content);