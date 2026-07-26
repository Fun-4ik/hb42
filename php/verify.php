<?php

require_once __DIR__ . '/advanced.php';

if(isset($_GET['email']) && $_GET['email'] != '' && isset($_POST['verification'])){

    $email = $_GET['email'];

    $stmt = mysqli_prepare($link, "SELECT id, verification_code, verified FROM users WHERE email = ?");

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
                $query = mysqli_prepare($link, "UPDATE `users` SET `verified` = ? WHERE `users`.`id` = ?");

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