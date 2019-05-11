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