<?php

namespace Class;

use mysqli;
use mysqli_stmt;

class Executor{

    protected ?int $id;

    private ?string $description = null;
    private ?array $author = null;
    private ?string $category = null;
    private ?array $subcategory = null;

    private ?array $ratings = null;

    public function __get(mixed $property)
    {
        return $this->$property;
    }

    public function __getExecutor(mysqli $link, int $id){
        $prepare_query = mysqli_prepare($link, "SELECT * FROM executor WHERE `id` = ?");

        if ($prepare_query) {
            mysqli_stmt_bind_param($prepare_query, "i", $id);
            

            if (mysqli_stmt_execute($prepare_query)) {

                mysqli_stmt_bind_result($prepare_query, $resid, $resdescription, $resauthor, $rescategory, $ressubcategory);

                $result_query = mysqli_stmt_fetch($prepare_query);

                mysqli_stmt_close($prepare_query);

                if ($result_query) {

                    $this->id = $id;
                    $this->description = $resdescription;
                    $this->author = $this->getAuthor($link,(int)$resauthor);
                    $this->category = $rescategory;
                    $this->subcategory = $this->getSubcategory($link, (int)$ressubcategory);

                    return true;
                }
            }
            else {
                mysqli_stmt_close($prepare_query);
                return false;
            }

            
        }
    }

    public function __addExecutor(mysqli $link, string $description, int $author, int $category, int $subcategory){

        $prepare_query = mysqli_prepare($link, "INSERT INTO `executor`(`description`, `author`, `category`, `subcategory`) VALUES (?,?,?,?)");

        if ($prepare_query) {
            mysqli_stmt_bind_param($prepare_query, "siii", $description, $author, $category, $subcategory);
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

    public function __addRating(mysqli $link, int $userId, float $rating, string $comment){

        if ($rating >= 1 && $rating <= 5 && !empty($comment)){
            $query = "INSERT INTO `ratings` (`executor`, `user`, `comment`, `rating`) VALUES (?, ?, ?, ?)";

            $prepare_query = mysqli_prepare($link, $query);

            if ($prepare_query) {
                mysqli_stmt_bind_param($prepare_query, "iisd", $this->id, $userId, $comment, $rating);
                mysqli_stmt_execute($prepare_query);

                if ($prepare_query) {
                    return true;
                }
                else{
                    return false;
                }
            }
        
        }

    }

    public function __getRatings(mysqli $link){
        $query = "SELECT * FROM `ratings` WHERE `ratings`.`executor` = ? ORDER BY `ratings`.`created_at` DESC";

        $prepare_query = mysqli_prepare($link, $query);

        if ($prepare_query) {
            mysqli_stmt_bind_param($prepare_query, "i", $this->id);
            mysqli_stmt_execute($prepare_query);

            $result = mysqli_stmt_get_result($prepare_query);

            mysqli_stmt_close($prepare_query);

            while ($row = mysqli_fetch_assoc($result)) {
                
                $id = $row['id'];
                $executor = $row['executor'];
                $user = $this->getAuthor($link,(int) $row['user']);
                $rating = $row['rating'];
                $comment = $row['comment'];
                $created_at = $row['created_at'];

                $arrayOfResults[$id] = ["id" => $id, 
                "executor" => $executor, 
                "user" => $user, 
                "rating" => $rating,
                "comment" => $comment,
                "created_at" => $created_at];
            }

            if (isset($arrayOfResults)) {
                $this->ratings = $arrayOfResults;
                return true;
            }else{
                return false;
            }

            

        }else {
            return "Ошибка в запросе.";
        }
        
    }

    private function arrayOfExecutors(mysqli $link, mixed $result){

        while ($row = mysqli_fetch_assoc($result)) {
            $executor = new self();

            $executor->id = $row['id'];
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

        $prepare_query = mysqli_prepare($link, "SELECT users.id, users.name, users.company_name, users.email, users.mobile_number FROM `users` WHERE users.id = ?");

        if ($prepare_query) {
            mysqli_stmt_bind_param($prepare_query, "i", $id);
            mysqli_stmt_execute($prepare_query);

            mysqli_stmt_bind_result($prepare_query, $uId, $uName, $uCName, $uEmail, $uPhone);
            mysqli_stmt_fetch($prepare_query);

            $response = ["id" => $uId, "name" => $uName, "company_name" => $uCName, "email" => $uEmail, "phone" => $uPhone];

            mysqli_stmt_close($prepare_query);

            return $response;
        }else{
            return null;
        }

    }

}
















?>