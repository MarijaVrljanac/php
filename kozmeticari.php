<?php

require "config.php";


class Kozmeticar{
    public $kozmeticarID;
    public $imePrezimeKozmeticara;
    public $email;
    public $tretmanID;

    public function __construct($kozmeticarID = null, $imePrezimeKozmeticara = null, $email =null , $tretmanID = null){
        $this->kozmeticarID = $kozmeticarID;
        $this->imePrezimeKozmeticara =$imePrezimeKozmeticara;
        $this->email = $email;
        $this->tretmanID = $tretmanID;
    }

    public static function getAll(mysqli $conn){
        $query = "SELECT * FROM kozmeticari";
        return $conn->query($query);
    }

    public static function getById($kozmeticarID,mysqli $conn){
        $query = "SELECT * FROM kozmeticari WHERE kozmeticarID = $kozmeticarID";
        $myArray = array();
        $result = $conn->query($query);
        if($result){
            while($row = $result->fetch_array()){
                $myArray[] = $row;
            }
        }

       
        return $myArray;
    }


    public static function getByTretmanId($tretmanID,mysqli $conn){
        $query = "SELECT * FROM kozmeticari WHERE tretmanID = $tretmanID";
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