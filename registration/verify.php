<?php require_once '../php/verify.php'?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подтверждение</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/general-style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/verify.css">
</head>
<body>
    <?require_once __DIR__.'/../php/header.php'?>

    <main>

            <form action="" method="POST" class="ver-block">
                <h1>Подтверждение почты</h1>
                <input type="text" name="verificationCode" class="input-code" placeholder="Код подтверждения">
                
                <input name="verification" type="submit" class="ver-enter" value="Подтвердить">
                
                <div class="error-ver">
                    <?echo $error ?? '';?>
                    <?echo $message ?? '';?>
                </div>
            </form>

    </main>
</body>
</html>