<?php
/**
 * Функция подсчета важности задачи
 * @param $date дата выполнения задачи
 * @param $hours сколько часов осталось до выполнения задачи
 */
function isImportantTask($date,$hours)   {
    if ($date === "Нет") {
        return false;
    }
    date_default_timezone_set('Europe/Moscow');
    $cur_date=time();
    $deadline_date=strtotime($date);
    $diff=($deadline_date - $cur_date);
    floor($diff/3600);
    if (floor($diff/3600) <= $hours) {
        return true;
    }
        return false;
}

/**
 * Функция проверки результата на ошибки
 * @param $result результат подключения к базе
 * @param $sql_list sql запрос
 */
function test_result($result,$sql_list){
    $con=mysqli_connect(db_adress,db_login,db_password,db_name);
    mysqli_set_charset($con,"utf8");
    if (!$result) {
        die('Ошибка в запросе БД ' . $sql_list .' '. mysqli_error($con));
    }
}

/**
 * Функция получения списка проектов пользователя
 * @param $user_id id пользователя
 */
function get_project_list($user_id) {
    $sql_projects_list =
    "SELECT projects.project_name as name, projects.id as project_id, COUNT(tasks.title) AS task_count
    FROM projects
    LEFT JOIN tasks ON projects.id = tasks.project_id
    WHERE projects.user_id=$user_id
    GROUP BY projects.id;";
    $con=mysqli_connect(db_adress,db_login,db_password,db_name);
    mysqli_set_charset($con,"utf8");

    $result_projects_list = mysqli_query($con,$sql_projects_list);
    test_result($result_projects_list,$sql_projects_list);
    $projects_list = mysqli_fetch_all($result_projects_list,MYSQLI_ASSOC);

    return  $projects_list;
}