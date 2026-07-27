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

$executorData = new Class\Executor;

$categoriesOfArray = $executorData->__categories($link);

if (isset($_POST['typeWorkCategory'])) {

    foreach ($executorData->__getExecutors($link, $_POST['typeWorkCategory']) as $executor) {
        $arrayOfResult[] = [
            "id" => $executor->id,
            "name" => $executor->name

        ];
    }

    if (isset($arrayOfResult)) {
        echo json_encode($arrayOfResult);
    }
    else{
        echo json_encode(null);
    }
    
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addContract'])) {
    
    if ($_POST['contract'] != '' && $_POST['sum'] != '' && $_POST['work_id'] != '' && $_POST['executor_id'] != '' && $_POST['type_works'] != '' && $_POST['executor'] != '') {
        
        $contract = ["number" => $_POST['contract'], "sum" => $_POST['sum'], "type_work" => $_POST['work_id'], "executor" => $_POST['executor_id']];

        $userData->__addContract($link, $contract);
    }

}

?>