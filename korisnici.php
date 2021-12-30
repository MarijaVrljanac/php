<?php

require "config.php";

class User{
    public $userId;
    public $imePrezime;
    public $email;
    public $lozinka;

    public function __construct($userId = null, $imePrezime = null, $email =null , $lozinka = null){
        $this->userId = $userId;
        $this->imePrezime =$imePrezime;
        $this->email = $email;
        $this->lozinka = $lozinka;
    }

    public static function getAll(mysqli $conn){
        $query = "SELECT * FROM korisnici";
        return $conn->query($query);
    }

    public static function getById($userId,mysqli $conn){
        $query = "SELECT * FROM korisnici WHERE userId = $userId";
        $myArray = array();
        $result = $conn->query($query);
        if($result){
            while($row = $result->fetch_array()){
                $myArray[] = $row;
            }
        }

       
        return $myArray;
    }

    
}

?>