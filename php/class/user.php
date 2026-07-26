<?php

namespace Class;

class User
{
    
    protected int $id;
    protected float $balance;

    private string $name;
    private string $birthDate;
    private string $email;
    private string $phone_number;
    private string $password;
    private int $verify;
    private int $role;

    public function __get($property)
    {
        return $this->$property;
    }

    // public function __construct(string $email, $link){
        
    //     $this->email = $email;
        
    //     $user_data = mysqli_fetch_assoc(
    //         mysqli_query($link,"SELECT * FROM `users` WHERE email = '$email'")
    //     );

    //     if (!empty($user_data)) {
    //         $this->id = $user_data['id'];
    //         $this->name = $user_data['name'];
    //         $this->birthDate = $user_data['birth_date'];
    //         $this->email = $user_data['email'];
    //         $this->phone_number = $user_data['mobile_number'];
    //         $this->password = $user_data['password'];
    //         $this->balance = 11.2;
    //     }
        
        
    // }

    public function __auth(string $email, $link){

        $sqli_fetch = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM `users` WHERE email = '$email'"));

        if (!empty($sqli_fetch)) {
            $this->id = $sqli_fetch['id'];
            $this->name = $sqli_fetch['name'];
            $this->birthDate = $sqli_fetch['birth_date'];
            $this->email = $sqli_fetch['email'];
            $this->phone_number = $sqli_fetch['mobile_number'];
            $this->password = $sqli_fetch['password'];
            $this->balance = $sqli_fetch['balance'];
            $this->verify = $sqli_fetch['verified'];

            if ($this->verify === 1) {
                return true;
            }
            else{
                return false;
            }

        }else{
            return false;
        }
    }

    public function __getUser(int $id, $link){

        $sqli_fetch = mysqli_fetch_assoc(mysqli_query($link,"SELECT * FROM `users` WHERE id = '$id'"));

        if (!empty($sqli_fetch)) {
            $this->id = $sqli_fetch['id'];
            $this->name = $sqli_fetch['name'];
            $this->birthDate = $sqli_fetch['birth_date'];
            $this->email = $sqli_fetch['email'];
            $this->phone_number = $sqli_fetch['mobile_number'];
            $this->password = $sqli_fetch['password'];
            $this->balance = $sqli_fetch['balance'];
            $this->role = $sqli_fetch['role'];
        }

    }

    

}


?>