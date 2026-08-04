    <header>
        <div class="header-content">
            <a href="../index.php"><img src="../assets/img/logo.png" alt="ХозБлог42" class="logo"></a>
            
            <nav class="main-menu">
                <a href="/../index.php" class="main-menu-children">Главная</a>
                <!-- <a href="#" class="main-menu-children">Партнерам</a> -->
                <a id="btnBonus" class="main-menu-children">Бонус</a>
                <a href="../about-us/index.php" class="main-menu-children">О НАС</a>
                <a href="<?if(isset($_SESSION['user_id'])){echo '../account/index.php';}else{echo '../login/index.php';}?>" class="main-menu-children">Личный кабинет</a>
            </nav>

            <div class="mobile-main-menu">
                <img class="burgerMobile" src="../assets/img/burgerMenu.png" alt="">
            </div>
        </div>
    </header>

    <dialog id="bonusModal">
        <div class="modal-content">
            <h2>Связаться с исполнителем</h2>

            <p>Все про бонус</p>
            
            <!-- Форма с методом dialog нативно закрывает окно при отправке -->
            <form method="dialog">
                <button class="close-btn">Закрыть</button>
            </form>
        </div>
    </dialog>

    <dialog id="burgerMenu">
        <div class="burgerMenu-content">
            <a href="/../index.php" class="main-menu-children">Главная</a>
            <!-- <a href="#" class="main-menu-children">Партнерам</a> -->
            <a id="btnBonus" class="main-menu-children">Бонус</a>
            <a href="../about-us/index.php" class="main-menu-children">О НАС</a>
            <a href="<?if(isset($_SESSION['user_id'])){echo '../account/index.php';}else{echo '../login/index.php';}?>" class="main-menu-children">Личный кабинет</a>
        </div>
    </dialog>

    <div class="modal-overlay"></div>
    <script src="../assets/js/header.js"></script>