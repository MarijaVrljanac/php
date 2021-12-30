<?php

require "config.php";
require "addNew.php";
require "korisnici.php";
require "kozmeticari.php";
require "tretmani.php";


error_reporting(0);

session_start();

if(!isset($_SESSION["userId"])){
    header("Location: index.php");
    exit();
  }

  

  $result = addNew::getAll($conn);
  

  if(!$result){
    echo "<script>alert('Greška!');</script>";
    die();
  }

  if($result->num_rows == 0){
      echo "Nema tretmana!";
      die();
  }
  else{

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blossom Beauty Salon</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="styleWelcome.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
</head>

<body>
    <p style=" font-size: xx-small; text-align: right;" id="font" hidden>aa</p>


    <div id="loginUserContainer" class="loginUserContainer">
        <div id="loginUserPicture" class="loginUserPicture">
            <img src="img/beauty.png" alt="">
        </div>
        <div id="loginUser" class="loginUser">
            <h1><?php 
            $result1 = User::getAll($conn);
            $imePrezime = "";
            while($raw = $result1->fetch_array()){
                if($raw["userId"] == $_SESSION["userId"]){  
                    $imePrezime = $raw["imePrezime"];
                }
            }
                echo $imePrezime;
              ?></h1>

            <h3 id="email"><?php 
            $result1 = User::getAll($conn);
            $email = "";
            while($raw = $result1->fetch_array()){
                if($raw["userId"] == $_SESSION["userId"]){  
                    $email = $raw["email"];
                }
            }
                echo $email;
              ?></h3>
        </div>
        <div>

        </div>
    </div>
    <div class="container">
        <div class="alert alert alert-primary" role="alert" style="background-color: #e89188; border: #fff">
        <h3 style="color: #fff; text-align: center;" >Nađite tretman po svojoj meri i ulepšajte sebi dan!</h3>
            
        </div>


        <!-- Deo iznad tabele -->

        <div class="row mb-3">

            <div class="col-3">
                <!-- <a href="logout.php" class="link">Logout</a> -->
                <button type="button" id="btnLogout" class="btn btn-primary" style="background-color: #b55964; border-color: #fff">Logout </button>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal" style="background-color: #b55964; border-color: #fff">Dodaj
                <i class="fa fa-asterisk"></i></button>
                <button type="button" onclick="sortTable()" class="btn btn-primary" style="background-color: #b55964; border-color: #fff">Sort </button>
                <label for="sort">Izaberite kriterijum:</label>
                <select name="criteria" id="criteria" class="criteria">
                    <option value="cena">Cena</option>
                    <option value="datumIVreme">Datum</option>
                    <!-- <option value="nazivtretmana">Naziv</option> -->
                </select>
            </div>
            <div class="col-9">
                <div class="input-group input-group-lg">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon2"><i class="fa fa-search"
                                aria-hidden="true"></i></span>
                    </div>
                    <input type="text" id="myInput" onkeyup="funkcijaZaPretragu()" class="form-control"
                        aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg"
                        placeholder="Nađi tretman..." id="searchinput">

                </div>

            </div>

        </div>

        <!-- Deo iznad tabele -->



        <!-- tabela -->
        <table class="table" id="tretmani">
            <thead>
                <tr>
                <th scope="col"></th>
                    <!-- <th scope="col">Tretman ID</th> -->
                    
                    <th scope="col">Naziv tretmana</th>
                    <th scope="col">Adresa lokala</th>
                    <th scope="col">Kozmetičar</th>
                    <th scope="col">Cena (RSD)</th>
                    <th scope="col">Datum i vreme</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
        while($row=$result->fetch_array()):
    ?>
                <tr>
                <td>
                        <label class="custom-radio-btn">
                            <input type="radio" name="checked-donut" value=<?php echo $row["tretmanID"] ?>>
                            <span class="checkmark"></span>
                        </label>
                    </td>
                                    

                    
                    <td id="nazivTretmana" class="align-middle"><?php echo $row["nazivTretmana"] ?></td>
                    <td id="adresaLokala" class="align-middle"><?php echo $row["adresaLokala"] ?></td>
                    <td id="kozmeticar" class="align-middle"><?php echo $row["kozmeticar"] ?></td>
                    <td id="cena" class="align-middle"><?php echo $row["cena"] ?></td>
                    <td id="datumIVreme" class="align-middle"><?php echo $row["datumIVreme"] ?></td>



                </tr>

                <?php 
    endwhile;
}
    ?>

            </tbody>
        </table>
        <!-- tabela -->



        <!-- DUGMAD ISPOD TABELEE -->

        <div class="dugmad">
            <a href="#" id="btnPreview" class="btn btn-success mr-3 profile" data-toggle="modal"
                data-target="#userViewModal" title="Profile"><i class="fa fa-address-card-o" aria-hidden="true"></i></a>

            <a href="#" id="btnChange" class="btn btn-warning mr-3 edituser" data-toggle="modal"
                data-target="#changeModal" title="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>
            <a href="#" id="btnDelete" formmethod="post" class="btn btn-danger deleteuser" data-userid="14"
                title="Delete"><i class="fa fa-trash-o fa-lg"></i></a>

        </div>

        <!-- DUGMAD ISPOD TABELEE -->






        <!-- profile modal start -->
        
        
        
        <div class="modal fade" id="userViewModal" tabindex="-1" role="dialog" aria-labelledby="userViewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Kozmetičar <i class="fa fa-user-o"
                                aria-hidden="true"></i></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container" id="profile">
                            <div class="row">
                                <div class="col-sm-6 col-md-4">
                                    <img src="http://placehold.it/100x100" id="Img" alt="" class="rounded responsive" />
                                </div>
                                <div class="col-sm-6 col-md-8">
                             
                                        <h3 id="imePrezimeKozmeticara" > </h3>
                                    
                                    
                                        <h3 class="fa fa-envelope" id="emailKozmeticara"> </h3>
                                    </div>                             
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- profile modal end -->



        <!-- ADD form modal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Novi tretman <i class="fa fa-asterisk"
                                aria-hidden="true"></i></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>         
                    <form id="addform" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">         
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Naziv tretmana:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-diamond"
                                                aria-hidden="true"></i>
                                    </div>
                                    <input type="text" class="form-control" id="nazivTretmana" name="nazivTretmana"
                                        required="required">
                                </div>
                            </div>
                           
                            <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Adresa lokala:</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-map-marker"
                                                    aria-hidden="true"></i>
                                        </div>
                                        <input type="text" class="form-control" id="adresaLokala" name="adresaLokala"
                                            required="required">
                                    </div>
                                </div>
                            <!-- <div class="form-group">
                                <label for="message-text" class="col-form-label">Klijent:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user-circle-o"
                                                aria-hidden="true"></i>
                                    </div>
                                    <input type="text" class="form-control" id="userName" name="userName"
                                        required="required" />
                                </div>
                            </div> -->
                            <!-- <div class="form-group">
                                <label for="message-text" class="col-form-label">Email:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope-o"
                                                aria-hidden="true"></i></span>
                                    </div>
                                    <input type="email" class="form-control" id="email" name="email"
                                        required="required" />
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Kozmetičar:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-address-card"
                                                aria-hidden="true"></i>
                                    </div>
                                    <input type="text" class="form-control" id="kozmeticar" name="kozmeticar" required="required"
                                        maxLength="" minLength="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Cena:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-money"
                                                aria-hidden="true"></i>
                                    </div>
                                    <input type="text" class="form-control" id="cena" name="cena" required="required"
                                        maxLength="" minLength="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Datum i vreme:</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01"><i
                                                class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="datetime-local" id="datumIVreme" name="datumIVreme" class="form-control"
                                            required="required" />
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" id="addButton">Submit</button>
                            <input type="hidden" name="action" value="addTretman">
                            <!-- <input type="hidden" name="tretmanID" id="tretmanID" value="addTretman"> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- ADD form modal end -->














        <!-- EDIT form modal -->

        <div class="modal fade" id="changeModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Izmeni tretman <i class="fa fa-asterisk"
                                aria-hidden="true"></i></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="editform" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input id="tretmanID" type="text" name="tretmanID" class="form-control" placeholder="Tretman ID *"  readonly />
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Naziv tretmana:</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-diamond"
                                                    aria-hidden="true"></i>
                                        </div>
                                        <input type="text" class="form-control" id="nazivTretmanaEdit" name="nazivTretmanaEdit"
                                            required="required">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Adresa lokala:</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-map-marker"
                                                    aria-hidden="true"></i>
                                        </div>
                                        <input type="text" class="form-control" id="adresaLokalaEdit" name="adresaLokalaEdit"
                                            required="required">
                                    </div>
                                </div>
                                <!-- <div class="form-group">
                                    <label for="message-text" class="col-form-label">Klijent:</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                    class="fa fa-user-circle-o" aria-hidden="true"></i>
                                        </div>
                                        <input type="text" class="form-control" id="userNameEdit" name="userNameEdit"
                                            required="required" />
                                    </div> -->
                                <!-- </div>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Email:</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-envelope-o"
                                                    aria-hidden="true"></i></span>
                                        </div>
                                        <input type="email" class="form-control" id="emailEdit" name="emailEdit"
                                            required="required" />
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Kozmetičar:</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-address-card"
                                                    aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="kozmeticarEdit" name="kozmeticarEdit"
                                            required="required" maxLength="" minLength="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Cena:</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-money"
                                                    aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" class="form-control" id="cenaEdit" name="cenaEdit"
                                            required="required" maxLength="" minLength="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="col-form-label">Datum i vreme:</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupFileAddon01"><i
                                                    class="fa fa-calendar" aria-hidden="true"></i></span>
                                        </div>
                                        <div class="custom-file">
                                            <input type="datetime-local" id="datumIVremeEdit" name="datumIVremeEdit" class="form-control"
                                                required="required" />
                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" id="addButton">Submit</button>
                                <input type="hidden" name="action" value="addTretman">
                                
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- EDIT form modal end -->























        <!-- JS, Popper.js, and jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    </div>
    <div id="overlay" style="display:none;">
        <div class="spinner-border text-danger" style="width: 3rem; height: 3rem;"></div>
        <br />
        Loading...
    </div>

    <script src="js/main.js"></script>
    <script>
    $(document).ready(function() {
        $('#overlay').fadeIn().delay(1000).fadeOut();
    });
    </script>




    <script>
    function sortTable() {
        var table, rows, switching, i, j, z, k, x, y, shouldSwitch;
        table = document.getElementById("tretmani");


        var e = document.getElementById("criteria");
        var result = e.options[e.selectedIndex].value;
        var p = document.getElementById("email").innerHTML;



        //SORT po datumu
        // sortira tako da najsveziji datumu idu prvi 
        if (result == "datumIVreme") {
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                for (j = i + 1; j < rows.length; j++) {
                    x = rows[i].getElementsByTagName("TD")[5];
                    y = rows[j].getElementsByTagName("TD")[5];

                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        rows[i].parentNode.insertBefore(rows[j], rows[i]);
                    }
                }
            }
        }



        //SORT po ceni
        // sortira tako da najjeftiniji postovi idu na vrh
        if (result == "cena") {
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                for (j = i + 1; j < rows.length; j++) {
                    x = rows[i].getElementsByTagName("TD")[4];
                    y = rows[j].getElementsByTagName("TD")[4];
                    z = parseInt(x.innerHTML);
                    k = parseInt(y.innerHTML);
                    if (z > k) {
                        rows[i].parentNode.insertBefore(rows[j], rows[i]);
                    }
                }
            }

        }


        //SORT po imenu tretmana
        //sortiranje vrsi po ASCII kodu
        // if (result == "nazivTretmana") {
        //     rows = table.rows;
        //     for (i = 1; i < (rows.length - 1); i++) {
        //         for (j = i + 1; j < rows.length; j++) { //0 ili 4 ne
        //             x = rows[i].getElementsByTagName("TD")[1];
        //             y = rows[j].getElementsByTagName("TD")[1];

        //             if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        //                 rows[i].parentNode.insertBefore(rows[j], rows[i]);
        //             }
        //         }
        //     }
        // }


    }

    document.getElementById('btnLogout').onclick = function() {
        window.location.href = "logout.php";
    }




    function funkcijaZaPretragu() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("tretmani");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    </script>

</body>



</html>