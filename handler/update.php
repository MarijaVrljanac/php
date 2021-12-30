<?php

require "../config.php";
require "../addNew.php";

if( isset($_POST['nazivTretmanaEdit']) && isset($_POST['adresaLokalaEdit'])
  && isset($_POST['kozmeticarEdit']) && isset($_POST['datumIVremeEdit']) && isset($_POST['cenaEdit'])){
    
    $obj=new AddNew($_POST['tretmanID'],$_POST['nazivTretmanaEdit'],$_POST['adresaLokalaEdit'],$_POST['kozmeticarEdit'],$_POST['datumIVremeEdit'],$_POST['cenaEdit']);
    $status=$obj->update($_POST['tretmanID'],$conn);
    
   
    if($status){
        echo "Success";
    }else{
        echo $status;
        echo "Failed";
    }
}
?>