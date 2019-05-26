<?php
/**
 * Функция подсчета важности таска
 */
function isImportantTask($date,$hours)   {
    if ($date === "Нет"){ //Если дата не задана, возвращаем false
        return false;
    }
    date_default_timezone_set('Europe/Moscow'); // Устанавливает временную зону
    $cur_date=time(); // Сохраняем текущее время
    $deadline_date=strtotime($date); // Сохраняем время выполнения задачи
    $diff=($deadline_date - $cur_date);// Вычисляем промежуток между настоящим временем и временем выполнения задачи
    floor($diff/3600); // Вычисляем округленную разницу в часах
    if (floor($diff/3600) <= $hours) {
        return true;
    }
    else    {
        return false;
    }

}

/**
 * Функция проверки результата на ошибки
 */
function test_result($result,$sql_list){
    if (!$result) {
    die('Ошибка в запросе БД ' . $sql_list .' '. mysqli_error($con));
    }
}

//
function get_project_list($user_id) {
    $sql_projects_list = "SELECT projects.project_name as name, projects.id as project_id, COUNT(tasks.title) AS task_count FROM projects
LEFT JOIN tasks ON projects.id = tasks.project_id
WHERE projects.user_id=$user_id
GROUP BY projects.id;";
$con=mysqli_connect('localhost','root','','doingsdone');
mysqli_set_charset($con,"utf8");

$result_projects_list = mysqli_query($con,$sql_projects_list);
test_result($result_projects_list,$sql_projects_list);
$projects_list = mysqli_fetch_all($result_projects_list,MYSQLI_ASSOC);

return  $projects_list;
}
