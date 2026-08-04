<?php

require_once __DIR__ . '/advanced.php';

if (isset($_GET['email']) && $_GET['email'] != '' && isset($_GET['code']) && $_GET['code'] != '') {
    $email = isset($_GET['email']) ? trim($_GET['email']) : '';
    $code = isset($_GET['code']) ? trim($_GET['code']) : '';

    if ($email !== '' && $code !== '') {
    
        // 1. Проверяем, есть ли пользователь с таким email и кодом, который ЕЩЕ НЕ верифицирован
        $query_check = "SELECT `id` FROM `user` WHERE `email` = ? AND `verification_code` = ? AND `verified` = 0";
        $stmt_check = mysqli_prepare($link, $query_check);
    
    if ($stmt_check) {
        mysqli_stmt_bind_param($stmt_check, "ss", $email, $code);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_bind_result($stmt_check, $user_id);
        $user_found = mysqli_stmt_fetch($stmt_check);
        mysqli_stmt_close($stmt_check);
        
        if ($user_found) {
            // 2. Пользователь найден! Обновляем его статус на верифицированный (verified = 1)
            // Также можно стереть проверочный код (выставить NULL), чтобы ссылку нельзя было использовать повторно
            $query_update = "UPDATE `user` SET `verified` = 1 WHERE `id` = ?";
            $stmt_update = mysqli_prepare($link, $query_update);
            
            if ($stmt_update) {
                mysqli_stmt_bind_param($stmt_update, "i", $user_id);
                mysqli_stmt_execute($stmt_update);
                mysqli_stmt_close($stmt_update);
                
                $message = "Вы успешно подтвердили свой аккаунт! Теперь можете войти.";
            } else {
                $message = "Ошибка при обновлении статуса в базе данных.";
            }
        } else {
            $message = "Ссылка недействительна. Возможно, аккаунт уже активирован или данные неверны.";
        }
    } else {
        $message = "Ошибка сервера при обработке запроса.";
    }
} else {
    $message = "Неверный формат ссылки подтверждения.";
}

}
elseif(isset($_GET['email']) && $_GET['email'] != '' && isset($_POST['verification'])){

    $email = $_GET['email'];

    $stmt = mysqli_prepare($link, "SELECT id, verification_code, verified FROM user WHERE email = ?");

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        
        mysqli_stmt_bind_result($stmt, $id, $verification_code, $verified);
        $user_exist = mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if ($user_exist) {
        
            $code = $_POST['verificationCode'];
            
            if ((string)$verification_code === (string)$code && (int)$verified === 0) {
                $new_verified = 1;
                $query = mysqli_prepare($link, "UPDATE `user` SET `verified` = ? WHERE `user`.`id` = ?");

                if ($query) {
                    mysqli_stmt_bind_param($query, "ii", $new_verified, $id);
                    mysqli_stmt_execute($query);
                    mysqli_stmt_close($query);

                    header("Location: ../login/index.php");
                    exit;
                }
            }
        
        } 
    }


}

?>