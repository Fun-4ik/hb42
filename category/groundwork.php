<?require_once  __DIR__ .'\..\php\category.php'?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Категория</title>
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
                    <h1>Здесь те, кто <?if (!empty($currentCategory )) {echo $currentCategory['name'];}?></h1>
                </div>

                
                
                <? if (!empty($arryOfExecutors) && !empty($currentCategory )) {

                    foreach ($currentCategory['subcategories'] as $subcategory) {?>
                
                <div class="category--content--item">
                    <div class="category--content--item--title">
                        <div class="category--content--item--title--name">
                            <img class="category--content--item--arrow" src="../assets/img/arrowBurger.png" alt="">
                            <h2><?echo $subcategory['name']?></h2>
                        </div>
                    </div>


                    <div class="category--content--inside hidden">
                    <?foreach ($arryOfExecutors as $key => $value) {

                            if ($subcategory['name'] === $value->subcategory['name']) {?>
                    
                    
                        <a href="../executor/index.php?executor=<?echo $value->id?>">
                        <div class="content--inside--unit">
                            <h2><?echo $value->author['name']?></h2>  
                        </div>
                        </a>
                    

                    <?}}?>

                    </div>

                </div>

                <?}}?>

            </div>
        </section>

    </main>
    <script src="../assets/js/category.js"></script>
</body>
</html>