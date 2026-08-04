<?php

date_default_timezone_set('Asia/Novokuznetsk');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$db_setup = [
    "host" => '127.0.0.1',
    "user" => 'root',
    "password" => 'root',
    "db" => 'db_hb42'
];

$link = mysqli_connect($db_setup['host'],$db_setup['user'],$db_setup['password'],$db_setup['db']);

$mail_setup = [
    "SMTPDebug" => 2,
    "Host" => 'smtp.timeweb.ru',
    "SMTPAuth" => true,
    "Username" => 'manager@cy586009.tw1.ru',
    "Password" => 'H6qO3XX80kCAsp',
    "SMTPSecure" => 'ssl',
    "Port" => 465,
    "CharSet" => 'UTF-8'
];

?>