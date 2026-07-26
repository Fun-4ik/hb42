<?php

require_once __DIR__ .'/../php/advanced.php';
spl_autoload_register();

session_start();

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['userLogin'] ?? '';
    $password = $_POST['userPassword'] ?? '';

    if ($email != '' && $password != ''){
        // 1. Ищем пользователя в БД
        
        $userData = new Class\User;

        // 2. Проверяем существование пользователя и валидность пароля
        if ($userData->__auth($email, $link) && password_verify($password, $userData->password)) {
        
            // Пароль верный! Записываем данные в сессию
            $_SESSION['user_id'] = $userData->id;
        
            // Перенаправляем в личный кабинет
            header("Location: ../account/index.php");
            exit;
        } else {
            // Неверный email или пароль
            $error = "Неверный логин или пароль.";
        }
    }else{
        $error = "Нужно заполнить поля.";
    }

    
}
?>