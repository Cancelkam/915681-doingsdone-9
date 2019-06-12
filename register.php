<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');

if (isset($_SESSION['user']['id'])) {
    header("Location: /index.php");
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $register = $_POST;
    $required_fields = ['email', 'password', 'name'];
    $errors = [];

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])){
            $errors[$field] = 'Не заполнено поле ' . $field;
        }
    }

    if (strlen($register['email']) > $email_lenght) {
        $errors['email'] = "Длина должна быть не более $email_lenght " . get_noun_plural_form($email_lenght,"знака","знаков","знаков");
    }
    if (strlen($register['name']) > $name_lenght) {
        $errors['name'] = "Длина должна быть не более $name_lenght " . get_noun_plural_form($name_lenght,"знака","знаков","знаков");
    }
    if ($errors === []){
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
        }
        if ($res && empty($errors)) {
            header("Location: /index.php");
            exit();
        }
    }
}
$layout_content = include_template('register.php', [
    'register' => $register,
    'errors' => $errors
    ]);

print($layout_content);