<?require_once  __DIR__ .'/../php/category.php'?>
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
    <?require_once __DIR__.'/../php/header.php'?>

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
                            <h2><?echo $value->author['company_name']?></h2>  
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