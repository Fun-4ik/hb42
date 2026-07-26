<?php

require_once __DIR__ . '/advanced.php';
require_once __DIR__ . '/mailsender.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registration'])) {
    // 1. Очистка и серверная валидация email
    $email = filter_var(trim($_POST['userEmail']), FILTER_VALIDATE_EMAIL);
    $password = trim($_POST['userPassword']);
    $user_name = $_POST['userName'];
    $birth_date = $_POST['userBirthDate'];
    $mobile_phone = $_POST['userPhone'];
    $balance = 0;
    $role = 1;
    $verified = 0;

    $error = '';

    if (!$email) {
        $error = 'Некорректный формат email.';
    }
    elseif (strlen($password) < 6) {
        // die("Ошибка: Пароль должен быть не менее 6 символов.");
        $error = 'Пароль должен быть не менее 6 символов.';
    }
    elseif ($password !== $_POST['userPasswordRepeat']){
        $error = 'Пароли не совпадают.';
    }
    else{

    $stmt = mysqli_fetch_assoc(mysqli_query($link ,"SELECT id FROM users WHERE (`email` = '$email' OR `mobile_number` = '$mobile_phone') AND `verified` = 1"));

    // 2. Проверка, существует ли уже такой email в БД
    if ($stmt != NULL) {
        $error = 'Этот email или номер мобильного телефона уже зарегистрированы.';
    }
    else{
        $stmt_2 = mysqli_fetch_assoc(mysqli_query($link ,"SELECT id FROM users WHERE `email` = '$email' OR `mobile_number` = '$mobile_phone'"));

        if ($stmt_2 != NULL) {
            $q_id= $stmt_2['id'];
            mysqli_query($link, "DELETE FROM `users` WHERE `id` = '$q_id'");
        }
        // 3. Хэширование пароля и генерация кода подтверждения
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT); // 6-значный код

        // 4. Запись пользователя в базу данных
        $stmt = mysqli_prepare($link, "INSERT INTO users (name, birth_date, email, mobile_number, password, balance, role, verification_code, verified) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"); 

        if ($stmt) {

            mysqli_stmt_bind_param($stmt, "sssssiisi", 
            $user_name, 
            $birth_date, 
            $email, 
            $mobile_phone, 
            $passwordHash, 
            $balance, 
            $role, 
            $verificationCode,
            $verified
            );
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            send_mail_code($mail_setup, $email, $verificationCode);

            $url_email = urlencode($email);

            header("Location: ../registration/verify.php?email=" . $url_email);
        }
    }
    }
}
?>