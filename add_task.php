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
    $task = $_POST;
    $required_fields = ['name', 'project'];
    $errors = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])){
            $errors[$field] = 'Поле не заполнено!';
        }
    }
    if (strlen($task['name']) > $task_name_lenght) {
        $errors['name'] = "Длина должна быть не более $task_name_lenght " . get_noun_plural_form($task_name_lenght,"знака","знаков","знаков");
    }
    if (!empty($task['date'])){
        if (strtotime($task['date']) < time()) {
            $errors['date'] = 'Неверная дата';
            }
        if (!is_date_valid($task['date'])){
            $errors['date'] = 'Неверный формат даты';
        }
    }
    if (!empty($_FILES['file']['name'])) {
        $filename = uniqid();
        move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $filename);
    }
    $is_project_match = false;
    foreach (get_project_list($user_id) as $project){
        if ($task['project'] === $project['project_id']) {
            $is_project_match = true;
            break;
        }
    }
    if ($is_project_match === false) {
        $errors['project'] = 'Неверный проект';
    }
    if ($errors === []){
        if (!empty($task['date'])){
            $sql_insert_task = "INSERT INTO tasks (title,due_date,project_id,user_id,file_link) VALUES ('" . $task['name'] . "','" . $task['date'] . "'," . $task['project'] . ",$user_id,'" . $filename . "');";
        }
        else {
            $sql_insert_task = "INSERT INTO tasks (title,project_id,user_id,file_link) VALUES ('" . $task['name'] . "'," . $task['project'] . ",$user_id,'" . $filename . "');";
        }
        $result = mysqli_query($con,$sql_insert_task);
        if ($result && empty($errors)) {
            header("Location: /index.php");
            exit();
        }
    }
}

$page_content = include_template('add_task.php',[
    'task'=> $task,
    'projects' => get_project_list($user_id),
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