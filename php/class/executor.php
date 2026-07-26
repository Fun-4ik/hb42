<?php

namespace Class;

use mysqli;
use mysqli_stmt;

class Executor{

    protected ?int $id;

    private ?string $name = null;
    private ?string $description = null;
    private ?array $author = null;
    private ?string $category = null;
    private ?array $subcategory = null;

    public function __get(mixed $property)
    {
        return $this->$property;
    }

    public function __getExecutor(mysqli $link, int $id){
        $prepare_query = mysqli_prepare($link, "SELECT * FROM executor WHERE `id` = ?");

        if ($prepare_query) {
            mysqli_stmt_bind_param($prepare_query, "i", $id);
            mysqli_stmt_execute($prepare_query);

            if ($prepare_query) {

                mysqli_stmt_bind_result($prepare_query, $resid, $resname, $resdescription, $resauthor, $rescategory, $ressubcategory);

                $result_query = mysqli_stmt_fetch($prepare_query);

                mysqli_stmt_close($prepare_query);

                if ($result_query) {

                    $this->id = $id;
                    $this->name = $resname;
                    $this->description = $resdescription;
                    $this->author = $this->getAuthor($link,(int)$resauthor);
                    $this->category = $rescategory;
                    $this->subcategory = $this->getSubcategory($link, (int)$ressubcategory);

                    return "Запрос обработан.";
                }
            }
            else {
                mysqli_stmt_close($prepare_query);
                return "Непредвиденная ошибка";
            }

            
        }
    }

    public function __addExecutor(mysqli $link, string $name, string $description, int $author, int $category, int $subcategory){

        $prepare_query = mysqli_prepare($link, "INSERT INTO `executor`(`name`, `description`, `author`, `category`, `subcategory`) VALUES (?,?,?,?,?)");

        if ($prepare_query) {
            mysqli_stmt_bind_param($prepare_query, "ssiii", $name, $description, $author, $category, $subcategory);
            mysqli_stmt_execute($prepare_query);

            if ($prepare_query) {
                return "Ваша карточка успешно добавлена.";
            }
            else {
                return "Непредвиденная ошибка";
            }

            mysqli_stmt_close($prepare_query);
        }

    }

    public function __viewExecutor(mysqli $link, int $author){

        $prepare_query = mysqli_prepare($link, "SELECT * FROM executor WHERE `author` = ?");
        
        if ($prepare_query) {
            mysqli_stmt_bind_param($prepare_query, "i", $author);
            mysqli_stmt_execute($prepare_query);

            $result = mysqli_stmt_get_result($prepare_query);

            mysqli_stmt_close($prepare_query);

            return $this->arrayOfExecutors($link, $result);
        }else{
            return null;
        }
        

    }

    public function __updExecutor(mysqli $link, array $arrExecutor){

        $prepare_query = mysqli_prepare($link, "UPDATE `executor` SET `description`=?,`category`=?,`subcategory`=? WHERE `id` = ?");

        if ($prepare_query) {
            mysqli_stmt_bind_param($prepare_query, "siii", $arrExecutor['description'], $arrExecutor['category'], $arrExecutor['subcategory'], $arrExecutor['id']);
            mysqli_stmt_execute($prepare_query);

            if ($prepare_query) {
                return "Ваша карточка успешно обновлена.";
            }
            else {
                return "Непредвиденная ошибка";
            }

            mysqli_stmt_close($prepare_query);
        }

    }

    public function __delExecutor(mysqli $link, int $id){

        $prepare_query = mysqli_prepare($link, "DELETE FROM `executor` WHERE `id` = ?");

        if ($prepare_query) {
            mysqli_stmt_bind_param($prepare_query, "i", $id);
            mysqli_stmt_execute($prepare_query);

            if ($prepare_query) {
                return true;
            }
            else {
                return false;
            }

            mysqli_stmt_close($prepare_query);
        }

    }

    public function __getExecutors(mysqli $link, int $category){

        $prepare_query = mysqli_prepare($link, "SELECT * FROM executor WHERE `category` = ?");

        if ($prepare_query) {
            mysqli_stmt_bind_param($prepare_query, "i", $category);
            mysqli_stmt_execute($prepare_query);

            $result = mysqli_stmt_get_result($prepare_query);

            mysqli_stmt_close($prepare_query);

            return $this->arrayOfExecutors($link, $result);
        }else{
            return null;
        }
        

    }

    public function __categories(mysqli $link){

        $prepare_query = mysqli_prepare($link, "SELECT * FROM category");

        if ($prepare_query) {
            mysqli_stmt_execute($prepare_query);

            $result = mysqli_stmt_get_result($prepare_query);

            mysqli_stmt_close($prepare_query);

            while ($row = mysqli_fetch_assoc($result)) {
                
                $id = $row['id'];
                $name = $row['name'];
                $subcategories = $this->arrayOfSubcategories($link, (int)$id);

                $resultArray[$id] = [
                    "id" => $id,
                    "name" => $name,
                    "subcategories" => $subcategories
                ];
            }

            if (isset($resultArray)) {
                return $resultArray;
            }else{
                return null;
            }
        }

    }

    private function arrayOfExecutors(mysqli $link, mixed $result){

        while ($row = mysqli_fetch_assoc($result)) {
            $executor = new self();

            $executor->id = $row['id'];
            $executor->name = $row['name'];
            $executor->description = $row['description'];
            $executor->author = $this->getAuthor($link,$row['author']);
            $categoryId = $this->getCategory($link,$row['category']);
            $executor->category = $categoryId['name'];
            $executor->subcategory = $this->getSubcategory($link,$row['subcategory']);

            $executors[] = $executor;
        }

        if (isset($executors)) {
            return $executors;
        }
        else {
            return null;
        }

    }

    private function arrayOfSubcategories(mysqli $link, int $categoryId){

        $prepare_query = mysqli_prepare($link, "SELECT * FROM `subcategory` WHERE `category` = ?");

        if ($prepare_query) {
            mysqli_stmt_bind_param($prepare_query,"i", $categoryId);
            mysqli_stmt_execute($prepare_query);

            $result = mysqli_stmt_get_result($prepare_query);

            mysqli_stmt_close($prepare_query);

            while ($row = mysqli_fetch_assoc($result)) {
                
                $id = $row['id'];
                $name = $row['name'];
                $category = $row['category'];

                $arraySubcategories[] = [
                    "id" => $id,
                    "name" => $name,
                    "category" => $category
                ];
            }

            if (isset($arraySubcategories)) {
                return $arraySubcategories;
            }
            else {
                return null;
            }
        
        }

    }

    /**
    * @return array{id: int|null, name: string|null}|null
    */

    private function getCategory(mysqli $link, int $id){

        $prepare_query = mysqli_prepare($link, "SELECT * FROM category WHERE `id` = ?");

            if ($prepare_query) {
            mysqli_stmt_bind_param($prepare_query, "i", $id);
            mysqli_stmt_execute($prepare_query);

            mysqli_stmt_bind_result($prepare_query, $resId, $resName);
            mysqli_stmt_fetch($prepare_query);

            $result = ["id"=>$resId, "name"=>$resName];

            mysqli_stmt_close($prepare_query);

            return $result;
            }else{
            return null;
            }

    }

    /**
    * @return array{id: int|null, name: string|null}|null
    */

    private function getSubcategory(mysqli $link, int $id){

        $prepare_query = mysqli_prepare($link, "SELECT * FROM subcategory WHERE `id` = ?");

            if ($prepare_query) {
            mysqli_stmt_bind_param($prepare_query, "i", $id);
            mysqli_stmt_execute($prepare_query);

            mysqli_stmt_bind_result($prepare_query, $resId, $resName, $resCAtegory);
            mysqli_stmt_fetch($prepare_query);

            $result = ["id"=>$resId, "name"=>$resName, "category"=>$resCAtegory];

            mysqli_stmt_close($prepare_query);

            return $result;
            }else{
            return null;
            }

    }

    private function getAuthor(mysqli $link, int $id){

        $prepare_query = mysqli_prepare($link, "SELECT users.id, users.name, users.email, users.mobile_number FROM `users` WHERE users.id = ?");

        if ($prepare_query) {
            mysqli_stmt_bind_param($prepare_query, "i", $id);
            mysqli_stmt_execute($prepare_query);

            mysqli_stmt_bind_result($prepare_query, $uId, $uName, $uEmail, $uPhone);
            mysqli_stmt_fetch($prepare_query);

            $response = ["id" => $uId, "name" => $uName, "email" => $uEmail, "phone" => $uPhone];

            mysqli_stmt_close($prepare_query);

            return $response;
        }else{
            return null;
        }

    }

}
















?>