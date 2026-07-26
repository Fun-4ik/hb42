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
    <header>
        <div class="header-content">
            <a href="../index.html"><img src="../assets/img/logo.png" alt="ХозБлог42" class="logo"></a>
            
            <nav class="main-menu">
                <a href="../index.php" class="main-menu-children">Главная</a>
                <!-- <a href="#" class="main-menu-children">Партнерам</a> -->
                <a href="#" class="main-menu-children">Бонус</a>
                <a href="../about-us/index.php" class="main-menu-children">О НАС</a>
                <a href="#" class="main-menu-children">Личный кабинет</a>
            </nav>

            <div class="mobile-main-menu">
                <img class="burgerMobile" src="../assets/img/burgerMenu.png" alt="">
            </div>
        </div>
    </header>

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