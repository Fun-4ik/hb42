<?require_once __DIR__ .'\php\main.php'?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ХозБлог42</title>
    <link rel="stylesheet" type="text/css" href="assets/css/general-style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="assets/css/main.css"/>
</head>
<body>
    <?require_once __DIR__.'/php/header.php'?>

    <main>
        <div class="main-content">

            <h2 class="main-content-container">
                Наконец-то: всё для частного домостроения — в одном месте!
                <br>Привет, друзья! У нас для вас отличная новость — появился первый в регионе информационно‑партнёрский сервис для тех, кто строит или планирует строить свой дом.
                Больше не нужно искать исполнителей по всему интернету, обзванивать десятки подрядчиков и гадать, кому можно доверять. Мы собрали проверенных профессионалов — от мастеров по фундаменту до ландшафтных дизайнеров. Всё в одном месте: от закладки первого камня до благоустройства участка.
                Выбирайте тех, кто вам нужен.
            </h2>

            <div class="main-content-container-plate">
                
                <?foreach ($arrayOfCategories as $category) {
                    
                ?>

                <a href="category/groundwork.php?category=<?echo $category['id'];?>"><div class="container-plate" data-template="<?echo $category['id'];?>">
                    <img src="assets/img/bricks.png" alt="">
                    <h2>Здесь те, кто</h2>
                    <p><?echo $category['name'];?></p>
                </div></a>

                <?}?>

            </div>

            <h2 class="main-content-container">
                Как это работает? Всего пять шагов:
                <ul style="list-style-type: none;">
                    <li>1. Вы выбираете нужную категорию. </li>
                    <li>2. Знакомитесь с портфолио исполнителей. Смотрите реальные фото работ, читайте отзывы.</li>
                    <li>3. Регистрируетесь на сайте. Это займёт пару минут.</li>
                    <li>4. Получаете контакт нашего партнёра. Никаких посредников: вы напрямую связываетесь с исполнителем, обсуждаете детали и сроки.</li>
                    <li>5. Заключаете договор. Всё официально и прозрачно — никаких подводных камней.</li>
                </ul>

                А теперь самое приятное - бонус!
                Представьте: построили дом, а на следующие работы — например, на обустройство террасы или монтаж освещения— потратили часть суммы бонусами. Экономия налицо!
                <br>
                <br>
                Строить стало проще, надёжнее и даже выгоднее!

            </h2>

        </div>
    </main>

    <footer>

    </footer>

    <script src="/assets/js/main.js"></script>
</body>
</html>