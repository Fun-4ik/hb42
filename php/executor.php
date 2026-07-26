<?php

spl_autoload_register();
require_once __DIR__ .'/../php/advanced.php';

session_start();

$idExecutor = $_GET['executor'];

if (isset($_SESSION['user_id'])) {
    $userData = new Class\User;
    $userData->__getUser($_SESSION['user_id'], $link);
}


$executorData = new Class\Executor;



$executorData->__getExecutor($link,$idExecutor);

?>