<?php
/**
 * Функция подсчета задач по заданным категориям
 */
function elements_count($project_list , $project_title) {
    $sum=0;
    foreach ($project_list as $value){
        if  ($value['category'] === $project_title){
            $sum++;
        }
    }
    return $sum;
}

/**
 * Функция подсчета разницы в часах
 */
function diff_hours($date)   {
    if ($date === "Нет"){ //Если дата не задана, возвращаем произвольное большое число
        return 1000;
    }
    date_default_timezone_set('Europe/Moscow'); // Устанавливает временную зону
    $cur_date=time(); // Сохраняем текущее время
    $deadline_date=strtotime($date); // Сохраняем время выполнения задачи
    $diff=($deadline_date - $cur_date);// Вычисляем промежуток между настоящим временем и временем выполнения задачи
    $hours=floor($diff/3600); // Вычисляем округленную разницу в часах
    return $hours;
}