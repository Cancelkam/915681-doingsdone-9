<?php
require_once('helpers.php');
require_once('functions.php');

session_start();

if (isset($_SESSION['user']['id'])) {
    $user_id = $_SESSION['user']['id'];
    $user_name =  $_SESSION['user']['name'];
}
 else {
     $user_id = 0;
 }
print_r($user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $task = $_POST;
    $required_fields = ['name', 'project'];
    $errors = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])){
            $errors[$field] = 'Поле не заполнено!';
        }
    }

    if (strtotime($task['date']) < time()) {
        $errors['date'] = 'Неверная дата';
        }

    if ( $_FILES['file']['type'] == 'image/jpeg' ){
    $filename = uniqid() . '.jpg';
    $task['path'] = $filename;
    move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $filename);
    }


    if ($errors == []){
            $con=mysqli_connect('localhost','root','','doingsdone');
            mysqli_set_charset($con,"utf8");
            $sql_insert_task = "INSERT INTO tasks (title,due_date,project_id,user_id,file_link) VALUES ('" . $task['name'] . "','" . $task['date'] . "'," . $task['project'] . ",$user_id,'" . $filename . "');";
            $result = mysqli_query($con,$sql_insert_task);

    }
}

$page_content = include_template('add_task.php',[
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