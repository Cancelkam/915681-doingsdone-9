<?php
session_start();
define('db_adress', 'localhost');
define('db_login' , 'root');
define('db_password', '');
define('db_name', 'doingsdone');
$con = mysqli_connect(db_adress, db_login,db_password,db_name);
mysqli_set_charset($con, 'utf8');
$email_lenght = '100';
$name_lenght = '30';
$task_name_lenght = '1000';
?>