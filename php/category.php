<?php

spl_autoload_register();
require_once __DIR__ .'/../php/advanced.php';

session_start();

$idCategory = (int)$_GET['category'];

$userData = new Class\User;

$executorData = new Class\Executor;

$arryOfExecutors = $executorData->__getExecutors($link, $idCategory);

$arryOfCategories = $executorData->__categories($link);

// Ищем данные этой категории в общем массиве всех категорий сайта
$currentCategory = null;
if (!empty($arryOfCategories)) {
    foreach ($arryOfCategories as $cat) {
        if ($cat['id'] === $idCategory) {
            $currentCategory = $cat;
            break; // Нашли, выходим из цикла поиска
        }
    }
}

?>