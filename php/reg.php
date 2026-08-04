<?php

spl_autoload_register();
require_once __DIR__ . '/advanced.php';
require_once __DIR__ . '/mailsender.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registration']) && !isset($_GET['ref'])) {

    $userdataReg = [
        "email" => trim($_POST['userEmail']),
        "password" => trim($_POST['userPassword']),
        "passwordRepeat" => trim($_POST['userPasswordRepeat']),
        "name" => $_POST['userName'],
        "birthday" => $_POST['userBirthDate'],
        "phone" => $_POST['userPhone'],
        "balance" => 0,
        "role" => 1
    ];

    $error = '';

    $newUser = new Class\User;
    $result_newUser = $newUser->__regUser($link, $userdataReg);

    if ($result_newUser === true) {
        send_mail_code($mail_setup, trim($_POST['userEmail']), $newUser->verificationCode);

        $url_email = urlencode(trim($_POST['userEmail']));

        header("Location: ../registration/verify.php?email=" . $url_email);
    }else{
        $error = $result_newUser;
    }       
        
}

if (isset($_GET['ref']) && $_GET['ref'] != '') {

    $newExecutor = new Class\User;
    $result_referral = $newExecutor->__checkRef($link, $_GET['ref']);

    if ($result_referral) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registration'])) {
    
            $userdataReg = [
                "companyName" => $_POST['companyName'],
                "desiredCategories" => $_POST['desiredCategories'],
                "city" => $_POST['city'],
                "email" => trim($_POST['userEmail']),
                "password" => trim($_POST['userPassword']),
                "passwordRepeat" => trim($_POST['userPasswordRepeat']),
                "name" => $_POST['userName'],
                "phone" => $_POST['userPhone'],
                "role" => 2
            ];

            $error = '';

            $result_newExecutor = $newExecutor->__registrationExecutor($link, $userdataReg, $_GET['ref']);

            if ($result_newExecutor === true) {
                $error = "Заявка успешно отправлена, после рассмотрения вам прийдет письмо на указанную почту.";
            }else{
                $error = $result_newExecutor;
            }
        }
    }else{
        $fatal_error = 'Данной ссылки не существует.';
    }
    


}



?>