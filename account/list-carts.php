<?require_once '../php/list-carts.php'?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Карточки предложений</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/general-style.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/header.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/list-carts.css">
</head>
<body>
    <?require_once __DIR__.'/../php/header.php'?>

    <main>

        <section class="list--section">

            <button class="add--button" id="openModalBtn">Добавить Карточку</button>

            <div class="carts--data">
                <?php if(empty($executorArray)){echo "У вас пока нет карточек";}else{foreach ($executorArray as $key => $unit) {?>
                <div class="cart--unit" data-cart="<?echo $unit->id;?>">
                    <h2><?echo $unit->subcategory['name'];?></h2>
                </div>
                <?}}?>
            </div>
            
        </section>

    </main>

    <dialog id="AddModal">
        <div class="modal-content">
            <h2>Добавить карточку</h2>

            <form action="" method="post" class="modal--form">
                <input type="hidden" id="edit_id" name="edit_id" value="">
                <input type="hidden" id="category_id" name="category" value="">
                <input type="hidden" id="subcategory_id" name="subcategory" value="">
                
                <input type="text" class="input--category" id="choice-input" list="options-list" placeholder="Выберите категорию">

                

                <datalist id="options-list">

                <?if (!empty($arrayOfCategories)) {
                    foreach ($arrayOfCategories as $keyc => $category) {?>

                    <option value="<?echo $category['name']?>" data-id="<?echo $category['id']?>"></option>
                
                <?}}?>
                
                </datalist>

                <input type="text" id="sub--list" class="input--subcategory" placeholder="Выберите подкатегорию">

                <?if (!empty($arrayOfCategories)) {
                    foreach ($arrayOfCategories as $key => $category) {?>

                    <datalist id="<?echo $category['id']?>">

                        <?if($category['subcategories'] != null){foreach ($category['subcategories'] as $subcategory) {?>
                            <option value="<?echo $subcategory['name']?>" data-id="<?echo $subcategory['id']?>"></option>
                        <?}}?>

                    </datalist>
                
                <?}}?>

                <input type="text" name="description" class="input--description" placeholder="Описание">
                <input type="submit" name="addCart" class="input--enter" value="Добавить">
                <div><?if(isset($formError)){echo $formError;}?></div>
            </form>
            <!-- Форма с методом dialog нативно закрывает окно при отправке -->
            <form method="dialog">
                <button class="delete-btn hidden-btn">Удалить</button>
                <button class="close-btn">Закрыть</button>
            </form>
        </div>
    </dialog>

    <script src="../assets/js/jquery-3.7.1.js"></script>
    <script src="../assets/js/listCarts.js"></script>
</body>
</html>