<?php

require "../config.php";
require "../addNew.php";



if(isset($_POST['nazivTretmana']) && isset($_POST['adresaLokala']) && isset($_POST['kozmeticar']) 
&& isset($_POST['datumIVreme']) && isset($_POST['cena'])){ 
   $addNew = new AddNew(null,$_POST['nazivTretmana'],$_POST['adresaLokala'],$_POST['kozmeticar'], $_POST['datumIVreme'], $_POST['cena']);
    $status = AddNew::add($addNew,$conn); 
    if($status){
        echo "Success";
    }else{
        echo $status;
        echo "Failed";
    }
}
?>