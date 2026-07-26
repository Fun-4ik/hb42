<?php

spl_autoload_register();
require_once __DIR__ .'/../php/advanced.php';

session_start();

$Categories = new Class\Executor;

$arrayOfCategories = $Categories->__categories($link);


?>