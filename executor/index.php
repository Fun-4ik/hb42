<?require_once __DIR__.'/../php/executor.php'?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?echo $executorData->name;?></title>
    <link rel="stylesheet" type="text/css" href="../assets/css/general-style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/executor.css">
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
                <a href="<?if(isset($_SESSION['user_id'])){echo '../account/index.php';}else{echo '../login/index.php';}?>" class="main-menu-children">Личный кабинет</a>
            </nav>

            <div class="mobile-main-menu">
                <img class="burgerMobile" src="../assets/img/burgerMenu.png" alt="">
            </div>
        </div>
    </header>

    <main>

         <div class="block--back--button">
            <a class="back--button" href="javascript:history.back()"><img src="../assets/img/arrowBurger.png" alt=""><h3>Назад</h3></a>
        </div>

        <section class="block--executor">

            <div class="name--executor">
                <h2>"<?echo $executorData->name;?>"</h2>
            </div>

            <div class="img--executor">
                <img src="../assets/img/empty.png" alt="">
                <img src="../assets/img/empty.png" alt="">
                <img src="../assets/img/empty.png" alt="">
                <img src="../assets/img/empty.png" alt="">
                <img src="../assets/img/empty.png" alt="">
                <img src="../assets/img/empty.png" alt="">
            </div>

            <div class="img--executor--adaptive">
                <img src="../assets/img/empty.png" alt="">
            </div>

            <button class="link--executor" id="openModalBtn">Связаться с исполнителем</button>

            <div class="reviews--executor">

                <div class="reviews--title">
                    <h2>Отзывы</h2>
                </div>

                <button class="reviews--public">Оставить отзыв</button>

                <div class="reviews--users--container">

                    <div class="review--unit">

                        <div class="review--container--user--rating">

                            <div class="review--username">
                                <h4>Иванов Петр Васильевич</h4>
                            </div>

                            <div class="review--rating">
                                1 2 3 4 5
                            </div>

                        </div>

                        <div class="review--description">
                            Описание
                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>
    
    <dialog id="linkModal">
        <div class="modal-content">
            <h2>Связаться с исполнителем</h2>

            <?if (isset($_SESSION['user_id'])) {?>
              
            <div>
                <h3>Телефон: <?echo $executorData->author['phone'];?></h3>
                <h3>Почта: <?echo $executorData->author['email'];?></h3>
            </div>

            <?}else{?>
            
                <h3>Для того что бы связаться с исполнителем, необходимо авторизоваться.</h3>
                <a href="../login/index.php"><button class="auth--button">Авторизоваться</button></a>

            <?}?>
            <!-- Форма с методом dialog нативно закрывает окно при отправке -->
            <form method="dialog">
                <button class="close-btn">Закрыть</button>
            </form>
        </div>
    </dialog>
    <script src="../assets/js/executor.js"></script>
</body>
</html>