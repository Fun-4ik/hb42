<?php

spl_autoload_register();
require_once __DIR__ .'/../php/advanced.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $userData = new Class\User;
    $userData->__getUser($link, $_SESSION['user_id']);
}

if (isset($_GET['executor']) && $_GET['executor'] != '') {
    $idExecutor = $_GET['executor'];

    $executorData = new Class\Executor;

    if ($executorData->__getExecutor($link,$idExecutor)) {
        
        $executorData->__getRatings($link);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addRating'])) {
        // Валидация и фильтрация входных данных

            $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
            $text = isset($_POST['text']) ? trim(htmlspecialchars($_POST['text'])) : '';

            if ($rating >= 1 && $rating <= 5 && !empty($text)){
        
                $resultAdd = $executorData->__addRating($link, $userData->id, $rating, $text);

                if ($resultAdd) {
                    header("Location: " . $_SERVER['REQUEST_URI']);
                    exit();
                }
        
            }

            unset($_POST['addRating']);
        }


    }else{
        //Неверный исполнитель
    }
}
else {
    echo '<script>window.history.back();</script>';
    exit;
}










?>