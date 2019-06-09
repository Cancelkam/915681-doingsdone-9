<?php
require_once('helpers.php');
require_once('functions.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $register = $_POST;
    $required_fields = ['email', 'password', 'name'];
    $errors = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])){
            $errors[$field] = 'Не заполнено поле ' . $field;
        }
    }

    if ($errors === []){
        $con=mysqli_connect('localhost','root','','doingsdone');
        mysqli_set_charset($con,"utf8");
        $sql_users = "SELECT id FROM users WHERE email = '" . $register['email'] ."'";
        $result = mysqli_query($con,$sql_users);

        if (mysqli_num_rows($result)>0) {
            $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
        }
        else {
            $password = password_hash($register['password'], PASSWORD_DEFAULT);

            $sql = 'INSERT INTO users (email, name, password) VALUES (?, ?, ?)';
            $stmt = db_get_prepare_stmt($con, $sql, [$register['email'], $register['name'], $password]);
            $res = mysqli_stmt_execute($stmt);
            print_r(mysqli_error($con));
        }
        if ($res && empty($errors)) {
            header("Location: /index.php");
            exit();
        }
    }

}



$layout_content = include_template('register.php', [
    'errors' => $errors
    ]);

print($layout_content);