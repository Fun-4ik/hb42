<?session_start();?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/general-style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/about-us.css">
</head>
<body>
    <header>
        <div class="header-content">
            <a href="../index.html"><img src="../assets/img/logo.png" alt="ХозБлог42" class="logo"></a>
            
            <nav class="main-menu">
                <a href="../index.php" class="main-menu-children">Главная</a>
                <!-- <a href="#" class="main-menu-children">Партнерам</a> -->
                <a href="#" class="main-menu-children">Бонус</a>
                <a href="#" class="main-menu-children">О НАС</a>
                <a href="<?if(isset($_SESSION['user_id'])){echo '../account/index.php';}else{echo '../login/index.php';}?>" class="main-menu-children">Личный кабинет</a>
            </nav>

            <div class="mobile-main-menu">
                <img class="burgerMobile" src="../assets/img/burgerMenu.png" alt="">
            </div>
        </div>
    </header>

    <main>

        <div class="main--container">
            <img src="../assets/img/logo.png" alt="logo">
            
            <div class="text--container">
                ХозБЛОГ42 - информационно партнерский сервис, интернет площадка для размещение и поиска...
            </div>
        </div>

    </main>
</body>
</html>