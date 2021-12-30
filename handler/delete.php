<?php

require "../config.php";
require "../addNew.php";

if(isset($_POST['tretmanID'])){
    $obj = new AddNew($_POST['tretmanID']);
    $status = $obj->deleteById($conn);
    if ($status){
        echo "Success";
    }else{
        echo "Failed";
    }
}

?>