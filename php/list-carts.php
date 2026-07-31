<?php

spl_autoload_register();
require_once __DIR__ .'/../php/advanced.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit;
}

$userData = new Class\User;

$userData->__getUser($link, (int)$_SESSION['user_id']);

if ($userData->role !==2) {
    header("Location: ../account/index.php");
    exit;
}

$executor = new Class\Executor;

$executorArray = $executor->__viewExecutor($link, $_SESSION['user_id']);

$arrayOfCategories = $executor->__categories($link);

if (isset($_POST['idCart'])) {
    
    $idCart = (int)$_POST['idCart'];

    foreach ($executorArray as $key => $exec) {
        if ($exec->id == $idCart) {
            
            $response = [
                'id' => $exec->id,
                'name' => $exec->author['company_name'],
                'description' => $exec->description,
                'category' => $exec->category,
                'subcategory' => $exec->subcategory
            ];

            header('Content-Type: application/json; charset=utf-8');

            echo json_encode($response);
        }
    }

    exit;

}


if (isset($_POST['addCart'])) {
    if ($_POST['category'] != '' && $_POST['subcategory'] != '' && $_POST['description'] != '') {

        if ($arrayOfCategories && !isset($arrayOfCategories[$_POST['category']])) {
            $formError = 'Выбирете категорию из списка.';
        }

        if (!isset($formError)) {

            if (!empty($_POST['edit_id'])) {

                $editExecutor = ['id' => $_POST['edit_id'],
                'subcategory' => $_POST['subcategory'],
                'description' => $_POST['description'],
                'category' => $_POST['category']
                ];

                $executor->__updExecutor($link,$editExecutor);
                    
            }else {
                $executorNew = new Class\Executor;
                $executorNew->__addExecutor($link, $_POST['description'], $_SESSION['user_id'], $_POST['category'], $_POST['subcategory']);
            }

            header("Location: ../account/list-carts.php");
            unset($_POST['addCart']);
            exit;
        }
    }
    else {
        $formError = 'Заполните все поля.';
    }
}

if (isset($_POST['deleteIdCart'])) {

    $responseDelete = $executor->__delExecutor($link,$_POST['deleteIdCart']);

    if ($responseDelete) {
        
        echo json_encode($responseDelete);
    }

    exit;

}
?>