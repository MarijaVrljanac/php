<?php

$hostname = "localhost";
$username = "root";
$lozinka = "";
$database = "login";

$conn = mysqli_connect($hostname, $username, $lozinka, $database) or exit("Neuspešna konekcija...");

?>