<?session_start();?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Благустройство</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/general-style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/category.css">
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

        <section class="category--bricks">

            <div class="img--container--category">
                <img src="../assets/img/empty.png" alt="">
                <img src="../assets/img/empty.png" alt="">
                <img src="../assets/img/empty.png" alt="">
                <img src="../assets/img/empty.png" alt="">
                <img src="../assets/img/empty.png" alt="">
                <img src="../assets/img/empty.png" alt="">
            </div>

            <div class="img--container--category--adaptive">
                <img src="../assets/img/empty.png" alt="">
            </div>

            <div class="info--category">
                
                <div class="name--info--category">
                    <h1>Здесь те, кто строят фундамент</h1>
                </div>

                <div class="category--content--item">
                    <div class="category--content--item--title">
                        <div class="category--content--item--title--name">
                            <img class="category--content--item--arrow category--content--item--arrow--rotate" src="../assets/img/arrowBurger.png" alt="">
                            <h2>Сваи винтовые</h2>
                        </div>
                    </div>

                    <div class="category--content--inside">
                        
                        <div class="content--inside--unit" href="#">
                            <h2>Исполнитель</h2>  
                        </div>
                        
                    </div>

                    <div class="category--content--inside">
                        
                        <div class="content--inside--unit" href="#">
                            <h2>Исполнитель</h2>  
                        </div>
                        
                    </div>
                    

                </div>

            </div>
        </section>

    </main>
</body>
</html>