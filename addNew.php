<?php

 

class AddNew{
    public $tretmanID;
    public $nazivTretmana;
    public $kozmeticar;
    public $adresaLokala;
    public $datumIvreme;
    public $cena;

    public function __construct($tretmanID = null, $nazivTretmana = null, $adresaLokala =null , $kozmeticar = null, $datumIvreme =null, $cena = null){
        $this->tretmanID = $tretmanID;
        $this->nazivTretmana = $nazivTretmana;
        $this->adresaLokala = $adresaLokala;
        $this->kozmeticar = $kozmeticar;
        $this->datumIvreme = $datumIvreme;
        $this->cena = $cena;
    }

    public static function getAll(mysqli $conn){
        $query = "SELECT * FROM tretmani";
        return $conn->query($query);
    }

    public static function getById($tretmanID,mysqli $conn){
        $query = "SELECT * FROM tretmani  t inner join kozmeticari k on t.kozmeticar =  k.kozmeticarID WHERE t.tretmanID = $tretmanID";
        $myArray = array();
        $result = $conn->query($query);
        if($result){
            while($row = $result->fetch_array()){
                $myArray[] = $row;
            }
        }

        return $myArray;
    }

    public function deleteById(mysqli $conn)
    {
        $query = "DELETE FROM tretmani WHERE tretmanID=$this->tretmanID";
        return $conn->query($query);
    }

    public static function add(AddNew $addNew, mysqli $conn)
    {
        //kada dajemo tabeli neki broj npr cenu ili id kozmeticara tada ne stavljamo ' ' 
        $q = "INSERT INTO tretmani(nazivTretmana,adresaLokala,kozmeticar,datumIvreme,cena) VALUES('$addNew->nazivTretmana','$addNew->adresaLokala',$addNew->kozmeticar,'$addNew->datumIvreme',$addNew->cena)";
        return $conn->query($q);
    }

    public function update($tretmanID,mysqli   $conn)
    {
        $query = "UPDATE tretmani set nazivTretmana = '$this->nazivTretmana', adresaLokala = '$this->adresaLokala', kozmeticar = $this->kozmeticar, datumIvreme = '$this->datumIvreme', cena = $this->cena WHERE tretmanID=$tretmanID";
      
        return $conn->query($query);
    }
}

?>