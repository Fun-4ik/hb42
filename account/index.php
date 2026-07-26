<?require_once '../php/account.php'?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/general-style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/account.css">
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
        <?if($userData->role === 1){?>
        <section class="user--section">
            <div class="user--name">
                <img src="../assets/img/Ellipse.png" alt="ava">
                <h2><?echo $userData->name?></h2>
            </div>

            <div class="user--data">
                <h2>Дата рождения: <?echo $userData->birthDate?></h2>
                <h2>Почта: <?echo $userData->email?></h2>
                <h2>Мобильный телефон: <?echo $userData->phone_number?></h2>
            </div>

            <form action="POST" class="user--contract">
                <input type="text" name="contract" class="input--contract" placeholder="Номер договора">
                <input type="text" name="sum" class="input--sum--contract" placeholder="Сумма">
                <input type="text" name="worker" class="input--worker--contract" placeholder="Исполнитель">
                <input type="text" name="type_works" class="input--type_works--contract" placeholder="Вид работ">
                <input type="submit" name="" class="contract--enter" value="Договор заключен">
            </form>

            <a class="exit--button" href="../php/exit.php">Выйти</a>
            
        </section>

        <?}
        elseif($userData->role === 2){
        ?>


        <section class="user--section">
            <div class="user--name">
                <img src="../assets/img/Ellipse.png" alt="ava">
                <h2>Исполнитель: <?echo $userData->name?></h2>
            </div>

            <div class="user--data">
                <h2>Дата рождения: <?echo $userData->birthDate?></h2>
                <h2>Почта: <?echo $userData->email?></h2>
                <h2>Мобильный телефон: <?echo $userData->phone_number?></h2>
            </div>

            <a class="exit--button" href="list-carts.php">Карточки предложений</a>
            <a class="exit--button" href="../php/exit.php">Выйти</a>
            
        </section>

        <?}?>

    </main>
</body>
</html>