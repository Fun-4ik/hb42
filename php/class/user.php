<?php

namespace Class;

use mysqli;
use mysqli_stmt;

class User
{
    
    protected ?int $id = null;
    protected ?float $balance = null;
    protected ?int $verificationCode = null; 

    private ?string $name = null;
    private ?string $birthday = null;
    private ?string $email = null;
    private ?string $phone = null;
    private ?string $password = null;
    private ?int $verified = null;
    private ?int $role = null;


    public function __get(mixed $property)
    {
        return $this->$property;
    }

    public function __auth(mysqli $link, string $email, string $password){

        $query_user = "SELECT `id`, `email`, `password`, `role`, `verified` FROM `user` WHERE `email` = ?";

        $prepare_query = mysqli_prepare($link, $query_user);

        if ($prepare_query) {
            
            mysqli_stmt_bind_param($prepare_query, "s", $email);
            mysqli_stmt_execute($prepare_query);
            mysqli_stmt_bind_result($prepare_query, $id, $db_email, $passwordHash, $role, $verified);
            mysqli_stmt_fetch($prepare_query);
            mysqli_stmt_close($prepare_query);

            if ($id != null && $passwordHash != null && $verified == 1) {

                if (password_verify($password, $passwordHash)) {
                    $query_userData = "SELECT `name`, `phone`, `birthday`, `balance` FROM `user_data` WHERE `id_user` = ?";

                    $prepare_query_step_2 = mysqli_prepare($link, $query_userData);

                    if ($prepare_query_step_2) {
                
                        mysqli_stmt_bind_param($prepare_query_step_2, "i", $id);
                        mysqli_stmt_execute($prepare_query_step_2);
                        mysqli_stmt_bind_result($prepare_query_step_2, $name, $phone, $birthday, $balance);
                        mysqli_stmt_fetch($prepare_query_step_2);
                        mysqli_stmt_close($prepare_query_step_2);

                        $this->id = $id;
                        $this->balance = $balance;
                        $this->name = $name;
                        $this->birthday = $birthday;
                        $this->email = $db_email;
                        $this->phone = $phone;
                        $this->password = $passwordHash;
                        $this->verified = $verified;
                        $this->role = $role;

                        return true;

                    }else {
                        return "Ошибка при обращении к БД";
                    }
                }else{
                    return "Не верный Пароль.";
                }
            }else {
                return "Не верный Email.";
            }
        }else {
            return "Ошибка при обращении к БД";
        }

    }

    public function __regUser(mysqli $link, array $userData){

        $success = false;

        if ($userData != null) {
            $email = filter_var(trim($userData['email']), FILTER_VALIDATE_EMAIL);
            $password = $userData['password'];
            $passwordRepeat = $userData['passwordRepeat'];
            $name = $userData['name'];
            $birthday = $userData['birthday'];
            $phone = $userData['phone'];
            $balance = $userData['balance'];
            $role = $userData['role'];

            if (!$email) {

                return "Некорректный формат email.";
            
            }elseif(strlen($password) < 6){

                return 'Пароль должен быть не менее 6 символов.';
            
            }elseif($password !== $passwordRepeat){

                return "Пароли не совпадают.";
            
            }else {

                $query_emailVerified = "SELECT `id`, `verified` FROM `user` WHERE `email` = ?";

                $prepare_query = mysqli_prepare($link, $query_emailVerified);

                if ($prepare_query) {

                    mysqli_stmt_bind_param($prepare_query, "s", $email);
                    mysqli_stmt_execute($prepare_query);
                    mysqli_stmt_bind_result($prepare_query, $id, $status);
                    mysqli_stmt_fetch($prepare_query);
                    mysqli_stmt_close($prepare_query);

                    if ($id != null && $status == 1) {
                        
                        return "Пользователь с таким Email уже зарегестрирован.";

                    }elseif($id != null && $status == 0){

                        $query_onDelete = "DELETE FROM `user` WHERE `id` = ?";
                        
                        $prepare_query = mysqli_prepare($link, $query_onDelete);

                        if ($prepare_query) {
                            mysqli_stmt_bind_param($prepare_query, "i", $id);
                            mysqli_stmt_execute($prepare_query);
                            mysqli_stmt_close($prepare_query);

                            $success = true;
                        }else{
                            return "Ошибка при обращении к БД";
                        }

                    }else{

                        $success = true;

                    }

                    if ($success === true) {

                        $query_user = "INSERT INTO user (`email`, `password`, `role`, `verification_code`, `verified`) VALUES (?, ?, ?, ?, ?)";
                        $query_userID = "SELECT `user`.`id` FROM user WHERE `email` = ?";
                        $query_userData = "INSERT INTO `user_data`(`id_user`, `name`, `phone`, `birthday`, `balance`) VALUES (?, ?, ?, ?, ?)";
                        
                        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                        $this->verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
                        $verified = 0;

                        $prepare_query_step_2 = mysqli_prepare($link, $query_user);

                        if ($prepare_query_step_2) {
                            
                            mysqli_stmt_bind_param($prepare_query_step_2, "ssiii", $email, $passwordHash, $role, $this->verificationCode, $verified);
                            mysqli_stmt_execute($prepare_query_step_2);
                            mysqli_stmt_close($prepare_query_step_2);

                            $prepare_query_step_3 = mysqli_prepare($link, $query_userID);

                            if ($prepare_query_step_3) {
                                
                                mysqli_stmt_bind_param($prepare_query_step_3, "s", $email);
                                mysqli_stmt_execute($prepare_query_step_3);
                                mysqli_stmt_bind_result($prepare_query_step_3, $temp_id);
                                mysqli_stmt_fetch($prepare_query_step_3);
                                mysqli_stmt_close($prepare_query_step_3);

                                if ($temp_id != null) {
                                    
                                    $prepare_query_step_4 = mysqli_prepare($link, $query_userData);

                                    if ($prepare_query_step_4) {
                                        
                                        mysqli_stmt_bind_param($prepare_query_step_4, "isssd", $temp_id, $name, $phone, $birthday, $balance);
                                        mysqli_stmt_execute($prepare_query_step_4);
                                        mysqli_stmt_close($prepare_query_step_4);

                                        return true;

                                    }else{
                                        return "Ошибка при обращении к БД";
                                    }

                                }else{
                                    return "Непредвиденная ошибка.";
                                }

                            }else{
                                return "Ошибка при обращении к БД";
                            }

                        }else{
                            return "Ошибка при обращении к БД";
                        }

                    }

                }else{
                    return "Ошибка при обращении к БД";
                }
                
            
            }
            
            
            
        }
        

    }

    public function __getUser(mysqli $link, int $id){

        $query_user = "SELECT `id`, `email`, `password`, `role`, `verified` FROM `user` WHERE `id` = ?";

        $prepare_query = mysqli_prepare($link, $query_user);

        if ($prepare_query) {
            
            mysqli_stmt_bind_param($prepare_query, "i", $id);
            mysqli_stmt_execute($prepare_query);
            mysqli_stmt_bind_result($prepare_query, $db_id, $email, $passwordHash, $role, $verified);
            mysqli_stmt_fetch($prepare_query);
            mysqli_stmt_close($prepare_query);

            if ($id != null && $verified == 1) {

                $query_userData = "SELECT `name`, `phone`, `birthday`, `balance` FROM `user_data` WHERE `id_user` = ?";

                $prepare_query_step_2 = mysqli_prepare($link, $query_userData);

                if ($prepare_query_step_2) {
                
                    mysqli_stmt_bind_param($prepare_query_step_2, "i", $id);
                    mysqli_stmt_execute($prepare_query_step_2);
                    mysqli_stmt_bind_result($prepare_query_step_2, $name, $phone, $birthday, $balance);
                    mysqli_stmt_fetch($prepare_query_step_2);
                    mysqli_stmt_close($prepare_query_step_2);

                    $this->id = $db_id;
                    $this->balance = $balance;
                    $this->name = $name;
                    $this->birthday = $birthday;
                    $this->email = $email;
                    $this->phone = $phone;
                    $this->password = $passwordHash;
                    $this->verified = $verified;
                    $this->role = $role;

                    return true;

                }else {
                    return "Ошибка при обращении к БД";
                }
                
            }else {
                return "Пользователь не существует";
            }
        }else {
            return "Ошибка при обращении к БД";
        }


        $sqli_fetch = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM `users` WHERE id = '$id'"));

        if (!empty($sqli_fetch)) {
            $this->id = $sqli_fetch['id'];
            $this->name = $sqli_fetch['name'];
            $this->birthday = $sqli_fetch['birth_date'];
            $this->email = $sqli_fetch['email'];
            $this->phone = $sqli_fetch['mobile_number'];
            $this->password = $sqli_fetch['password'];
            $this->balance = $sqli_fetch['balance'];
            $this->role = $sqli_fetch['role'];
        }

    }

    public function __addContract(mysqli $link, array $contract){
        
        $query = "INSERT INTO `contract`(`number`, `sum`, `type_work`, `executor`, `user`) VALUES (?,?,?,?,?)";

        $prepare_query = mysqli_prepare($link, $query);

        if ($prepare_query) {
            mysqli_stmt_bind_param($prepare_query,"siiii", $contract['number'], $contract['sum'], $contract['type_work'], $contract['executor'], $this->id);
            
            if (mysqli_stmt_execute($prepare_query)) {
                return true;
            }
            else {
                return false;
            }

            mysqli_stmt_close($prepare_query);
        }

    }

    public function __registrationExecutor(mysqli $link, array $executorData, string $referral_code){

        $success = false;

        if ($executorData != null && $referral_code != null) {
            
            $companyName = $executorData['companyName'];
            $desiredCategories = $executorData['desiredCategories'];
            $city = $executorData['city'];
            $email = filter_var(trim($executorData['email']), FILTER_VALIDATE_EMAIL);
            $password = $executorData['password'];
            $passwordRepeat = $executorData['passwordRepeat'];
            $name = $executorData['name'];
            $phone = $executorData['phone'];
            $role = $executorData['role'];

            if (!$email) {

                return "Некорректный формат email.";
            
            }elseif(strlen($password) < 6){

                return 'Пароль должен быть не менее 6 символов.';
            
            }elseif($password !== $passwordRepeat){

                return "Пароли не совпадают.";
            
            }else {

                $query_emailVerified = "SELECT `id`, `verified` FROM `user` WHERE `email` = ?";

                $prepare_query = mysqli_prepare($link, $query_emailVerified);

                if ($prepare_query) {

                    mysqli_stmt_bind_param($prepare_query, "s", $email);
                    mysqli_stmt_execute($prepare_query);
                    mysqli_stmt_bind_result($prepare_query, $id, $status);
                    mysqli_stmt_fetch($prepare_query);
                    mysqli_stmt_close($prepare_query);

                    if ($id != null && $status == 1) {
                        
                        return "Пользователь с таким Email уже зарегестрирован.";

                    }elseif($id != null && $status == 0){

                        $query_onDelete = "DELETE FROM `user` WHERE `id` = ?";
                        
                        $prepare_query = mysqli_prepare($link, $query_onDelete);

                        if ($prepare_query) {
                            mysqli_stmt_bind_param($prepare_query, "i", $id);
                            mysqli_stmt_execute($prepare_query);
                            mysqli_stmt_close($prepare_query);

                            $success = true;
                        }else{
                            return "Ошибка при обращении к БД";
                        }

                    }else{

                        $success = true;

                    }

                    if ($success === true) {

                        $query_referral_applications = "INSERT INTO `referral_applications`(`referrer_id`, `company_name`, `director_name`, `city`, `email`, `password`, `desired_categories`) VALUES (?,?,?,?,?,?,?)";
                        
                        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                        $prepare_query_step_2 = mysqli_prepare($link, $query_referral_applications);

                        if ($prepare_query_step_2) {

                            $ref_id = $this->getRefId($link,$referral_code);

                            if ($ref_id != null) {
                                mysqli_stmt_bind_param($prepare_query_step_2, "issssss", $ref_id, $companyName, $name, $city, $email, $passwordHash, $desiredCategories);
                                mysqli_stmt_execute($prepare_query_step_2);
                                mysqli_stmt_close($prepare_query_step_2);
                                    
                                return true;
                            }else{
                                return "Реферальная ссылка не найдена";
                            }

                            
                            
                        }else{
                            return "Ошибка при обращении к БД";
                        }

                    }

                }else{
                    return "Ошибка при обращении к БД";
                }
                
            
            }
            
            
            
        }

    }

    public function __checkRef(mysqli $link, ?string $referral_code = '') :bool{

        $query = "SELECT `id` FROM `user` WHERE `referral_code` = ? ";

        $prepare_query = mysqli_prepare($link, $query);

        if ($prepare_query) {
            
            mysqli_stmt_bind_param($prepare_query, "s", $referral_code);
            mysqli_stmt_execute($prepare_query);
            mysqli_stmt_bind_result($prepare_query, $id);
            mysqli_stmt_fetch($prepare_query);
            mysqli_stmt_close($prepare_query);

            if ($id != null) {
                return true;
            }
            else{
                return false;
            }
        }else{
            return false;
        }

    }

    private function getRefId(mysqli $link, string $ref){
        $query = "SELECT `id` FROM `user` WHERE `referral_code` = ? ";

        $prepare_query = mysqli_prepare($link, $query);

        if ($prepare_query) {
            
            mysqli_stmt_bind_param($prepare_query, "s", $ref);
            mysqli_stmt_execute($prepare_query);
            mysqli_stmt_bind_result($prepare_query, $id);
            mysqli_stmt_fetch($prepare_query);
            mysqli_stmt_close($prepare_query);

            if ($id != null) {
                return $id;
            }
            else{
                return false;
            }
        }else{
            return false;
        }
    }

}


?>