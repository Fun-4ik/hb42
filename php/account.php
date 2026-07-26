<?php

spl_autoload_register();
require_once __DIR__ .'/../php/advanced.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

$userData = new Class\User;

$userData->__getUser((int)$_SESSION['user_id'], $link);



?>