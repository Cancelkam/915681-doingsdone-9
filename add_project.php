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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $project = $_POST;

    $errors = [];


    if (empty($_POST['name'])){
        $errors['project'] = 'Поле не заполнено!';
    }


    if ($errors == []){
            $con=mysqli_connect('localhost','root','','doingsdone');
            mysqli_set_charset($con,"utf8");
            $sql_insert_project = "INSERT INTO projects (project_name , user_id) VALUES ('" . $project['name'] . "',$user_id);";
            $result = mysqli_query($con,$sql_insert_project);


    }
}

$page_content = include_template('add_project.php',[
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