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
    <?require_once __DIR__.'/../php/header.php'?>

    <main>
        <?if($userData->role === 1){?>
        <section class="user--section">
            <div class="user--name">
                <img src="../assets/img/Ellipse.png" alt="ava">
                <h2><?echo $userData->name?></h2>
            </div>

            <div class="user--data">
                <h2>Дата рождения: <?echo $userData->birthday?></h2>
                <h2>Почта: <?echo $userData->email?></h2>
                <h2>Мобильный телефон: <?echo $userData->phone?></h2>
            </div>

            <form action="" method="POST" class="user--contract">
                <input type="text" name="contract" class="input--contract" placeholder="Номер договора">
                <input type="text" name="sum" class="input--sum--contract" placeholder="Сумма">
                <input type="hidden" id="selected_work_id" name="work_id" value="">
                <input type="hidden" id="selected_executor_id" name="executor_id" value="">

                <div class="typeWorksList--container">
                <input autoComplete="off" type="text" name="type_works" class="input--type_works--contract" placeholder="Вид работ">
                <div class="typeWorksList">
                            <div class="typeWorksListContent">
                                <?if(isset($categoriesOfArray) && $categoriesOfArray != null){ foreach($categoriesOfArray as $category){?>
                                <p class="typeWorksListUnit" data-typework="<?echo $category['id'];?>"><?echo $category['name'];?></p>
                                <?}}?>
                            </div>
                        </div>
                </div>

                <div class="executorList--container">
                <input autoComplete="off" type="text" placeholder="Исполнитель" class="input--executor" name="executor">
                        <div class="executorList">
                            <div class="executorListContent">
                            </div>
                        </div>
                </div>

                <input type="submit" name="addContract" class="contract--enter" value="Договор заключен">
            </form>

            <a class="exit--button" href="../php/exit.php">Выйти</a>
            
        </section>

        <?}
        elseif($userData->role === 2){
        ?>


        <section class="user--section">
            <div class="user--name">
                <img src="../assets/img/Ellipse.png" alt="ava">
                <h2><?echo $userData->name?></h2>
            </div>

            <div class="user--data">
                <h2>Организация: <?echo $userData->company_name?></h2>
                <h2>Почта: <?echo $userData->email?></h2>
                <h2>Мобильный телефон: <?echo $userData->phone?></h2>
            </div>

            <a class="exit--button" href="list-carts.php">Карточки предложений</a>
            <a class="exit--button" href="../php/exit.php">Выйти</a>
            
        </section>

        <?}
        elseif($userData->role === 36){
        ?>


        <section class="user--section">
            <div class="user--name">
                <img src="../assets/img/Ellipse.png" alt="ava">
                <h2>Исполнитель: <?echo $userData->name?></h2>
            </div>

            <a class="exit--button" href="../php/admin_panel.php">Админ панель</a>
            <a class="exit--button" href="../php/exit.php">Выйти</a>
            
        </section>

        <?}?>

    </main>
    <script src="/assets/js/jquery-3.7.1.js"></script>
    <script src="/assets/js/account.js"></script>
</body>
</html>