<?php

require "../config.php";
require "../addNew.php";

if(isset($_POST['tretmanID'])){
    $myArray = AddNew::getById($_POST['tretmanID'], $conn);
    echo json_encode($myArray);
}

?>