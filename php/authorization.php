<?php

spl_autoload_register();
require_once __DIR__ .'/../php/advanced.php';

session_start();

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['userLogin'] ?? '';
    $password = $_POST['userPassword'] ?? '';

    if ($email != '' && $password != ''){
        // 1. Ищем пользователя в БД
        $userData = new Class\User;
        $resultUser = $userData->__auth($link, $email, $password);
        // 2. Проверяем существование пользователя и валидность пароля
        if ($resultUser === true) {
        
            // Пароль верный! Записываем данные в сессию
            $_SESSION['user_id'] = $userData->id;
        
            // Перенаправляем в личный кабинет
            header("Location: ../account/index.php");
            exit;
        } else {
            // Неверный email или пароль
            $error = $resultUser;
        }
    }else{
        $error = "Нужно заполнить поля.";
    }

    
}
?>