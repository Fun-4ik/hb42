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
    <?require_once __DIR__.'/../php/header.php'?>

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

                <?if(isset($_SESSION['user_id'])){?> <button class="reviews--public" id="openRatingBtn">Оставить отзыв</button> <?}?>
                
                <div class="reviews--users--container">

                    <?if ($executorData->ratings != null) {
                    foreach ($executorData->ratings as $rating) {?>

                    <div class="review--unit">

                        <div class="review--container--user--rating">

                            <div class="review--username">
                                <h4><?echo $rating['user']['name'];?></h4>
                            </div>

                            <div class="review--rating">
                                <?php echo str_repeat('★', $rating['rating']) . str_repeat('☆', 5 - $rating['rating']); ?>
                            </div>

                        </div>

                        <div class="review--description">
                            <?echo $rating['comment'];?>
                        </div>

                    </div>

                    <?}}?>
                
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

    <?if (isset($_SESSION['user_id'])) {?>
    <dialog id="ratingModal">
        <div class="modal-content">
            <h2>Оставить отзыв</h2>

            <form action="" method="post" class="rating--form">
                    
                <div class="rating-stars">
                    <input type="radio" id="star5" name="rating" value="5" required /><label for="star5" title="Отлично">★</label>
                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Хорошо">★</label>
                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Нормально">★</label>
                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Плохо">★</label>
                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Ужасно">★</label>
                </div>

                <textarea name="text" required class="comment--input" placeholder="Поделитесь вашим впечатлением..."></textarea>

                <input type="submit" name="addRating" class="add--button" value="Оставить отзыв">

            </form>
              
            <!-- Форма с методом dialog нативно закрывает окно при отправке -->
            <form method="dialog">
                <button class="close-btn">Закрыть</button>
            </form>
        </div>
    </dialog>
    <?}?>
    <script src="../assets/js/executor.js"></script>
</body>
</html>