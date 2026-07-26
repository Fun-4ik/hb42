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
    "Host" => 'smtp.gmail.com',
    "SMTPAuth" => true,
    "Username" => 'danil.protasov.95@gmail.com',
    "Password" => 'ryhk kdnc dvyb whjy',
    "SMTPSecure" => 'ssl',
    "Port" => 465,
    "CharSet" => 'UTF-8'
];

?>