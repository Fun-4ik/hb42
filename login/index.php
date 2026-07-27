<?php require_once '../php/authorization.php'?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/general-style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/login.css">
</head>
<body>
    <?require_once __DIR__.'/../php/header.php'?>

    <main>

            <form action="" method="POST" class="login-block">
                <h1>Авторизация</h1>
                <input type="text" name="userLogin" class="input-login" placeholder="Почта">
                <input type="password" name="userPassword" class="input-password" placeholder="Пароль">
                
                <div class="login-btns"> 
                    <input name="logining" type="submit" class="login-enter" value="Войти">
                    <a href="#" id="ForgotPass" class="login-forgot-pass">Забыли пароль?</a>
                </div>

                <a href="../registration/index.php" class="reg-btn">Зарегистрироваться</a>
                
                <div class="error-auth">
                    <?echo $error ?? '';?>
                </div>
            </form>

    </main>
</body>
</html>