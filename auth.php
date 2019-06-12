<?php
require_once('helpers.php');
require_once('functions.php');
require_once('init.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form = $_POST;

    $required = ['email', 'password'];
    $errors = [];
    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    }
    $email = mysqli_real_escape_string($con, $form['email']);
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $res = mysqli_query($con, $sql);

    $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

    if (!count($errors) and $user) {
        if (password_verify($form['password'], $user['password'])) {
            $_SESSION['user'] = $user;
        }
        else {
            $errors['password'] = 'Неверный пароль';
        }
    }

    if (count($errors)) {
        $page_content = include_template('auth.php', ['form' => $form, 'errors' => $errors]);
    }
    else {
        header("Location: /index.php");
        exit();
    }
}
else {
    if (isset($_SESSION['user'])) {
        $page_content = include_template('index.php', ['username' => $_SESSION['user']['name']]);
    }
    else {
        $page_content = include_template('auth.php', []);
    }
}


$layout_content = include_template('auth.php', [
    'form'=> $form,
    'errors' => $errors
    ]);

print($layout_content);