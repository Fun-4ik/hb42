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

            <form action="" method="POST" class="ver-block">
                <h1>Подтверждение почты</h1>
                <input type="text" name="verificationCode" class="input-code" placeholder="Код подтверждения">
                
                <input name="verification" type="submit" class="ver-enter" value="Подтвердить">
                
                <div class="error-ver">
                    <?echo $error ?? '';?>
                </div>
            </form>

    </main>
</body>
</html>