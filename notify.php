<?php
require_once('vendor/autoload.php');
require_once('functions.php');
require_once('helpers.php');
require_once('init.php');

session_start();

if (isset($_SESSION['user']['id'])) {
    $user_id = $_SESSION['user']['id'];
    $user_name =  $_SESSION['user']['name'];
}
else {
    $user_id = 0;
 }

$transport = new Swift_SmtpTransport("phpdemo.ru", 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$mailer = new Swift_Mailer($transport);

$logger = new Swift_Plugins_Loggers_ArrayLogger();
$mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

$sql='SELECT title, due_date, name, email FROM tasks JOIN users ON tasks.user_id=users.id WHERE tasks.due_date=CURRENT_DATE()';

$res = mysqli_query($con, $sql);


if ($res && mysqli_num_rows($res)) {
    $tasks = mysqli_fetch_all($res, MYSQLI_ASSOC);
    foreach ($tasks as $task) {
        $message = new Swift_Message();
        $message->setSubject("Уведомление от сервиса «Дела в порядке»");
        $message->setFrom(['keks@phpdemo.ru' => 'DoingsDone']);
        $message->setto($task['email']);

        $msg_content = include_template('email_message.php', ['tasks' => $task]);
        $message->setBody($msg_content, 'text/html');


        $result = $mailer->send($message);
    }
    if ($result) {
        print("Рассылка успешно отправлена");
    }
    else {
        print("Не удалось отправить рассылку: " . $logger->dump());
    }
}
