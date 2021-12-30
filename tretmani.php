<?php

require "config.php";


class Tretman{
    public $tretmanID;
    public $nazivTretmana;
    public $adresaLokala;
    public $kozmeticar;
    public $datumIVreme;
    public $cena;

    public function __construct($tretmanID = null, $nazivTretmana = null, $adresaLokala =null , $kozmeticar = null, $datumIVreme = null, $cena = null){
        $this->tretmanID = $tretmanID;
        $this->nazivTretmana =$nazivTretmana;
        $this->adresaLokala = $adresaLokala;
        $this->kozmeticar = $kozmeticar;
        $this->datumIVreme = $datumIVreme;
        $this->cena = $cena;
    }

    public static function getAll(mysqli $conn){
        $query = "SELECT * FROM tretmani";
        return $conn->query($query);
    }

    public static function getById($tretmanID,mysqli $conn){
        $query = "SELECT * FROM tretmani WHERE tretmanID = $tretmanID";
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