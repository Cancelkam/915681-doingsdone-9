<?php
require_once('helpers.php');
require_once('functions.php');

//Проверяем отправлена ли форма
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $task = $_POST;
    $required_fields = ['name', 'project'];
    $errors = [];

    //Проверка на заполненность необходимых полей
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])){
            $errors[$field] = 'Поле не заполнено!';
        }
    }

    //Проверка на корректность даты
    if (strtotime($task['date']) < time()) {
        $errors['date'] = 'Неверная дата';
        }

    //Задаем название и путь загружаемому файлу
    if ( $_FILES['file']['type'] == 'image/jpeg' ){
    $filename = uniqid() . '.jpg';
    $task['path'] = $filename;
    move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $filename);
    }


    if ($errors == []){
            $con=mysqli_connect('localhost','root','','doingsdone');
            mysqli_set_charset($con,"utf8");
            $sql_insert_task = "INSERT INTO tasks (title,due_date,project_id,user_id,file_link) VALUES ('" . $task['name'] . "','" . $task['date'] . "'," . $task['project'] . ",2,'" . $filename . "');";
            $result = mysqli_query($con,$sql_insert_task);

    }
}

$page_content = include_template('add.php',[
    'projects' => get_project_list(2),
    'errors' => $errors
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'title' => 'Добавление задачи',
    'projects' => get_project_list(2),
    ]);

    print($layout_content);