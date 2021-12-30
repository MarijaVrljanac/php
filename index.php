<?php

include 'config.php';

session_start();

error_reporting(0); 
// ova linija koda sprecava greske koje nastaju prilikom pogresnog unosa podatak prilikom logovanja.
//Tacnije kada su kredencijali netacni oni ce ostati upisani u poljima radi lakseg prepravljanja.

if(isset($_SESSION["userId"])){
  header("Location: welcome.php");
}

if(isset($_POST["signup"])){
  $imePrezime = mysqli_real_escape_string($conn,$_POST["signup_imePrezime"]); // ako se ovaj kod ne napise moze doci do sql injection-a
  $email = mysqli_real_escape_string($conn,$_POST["signup_email"]);
  $lozinka = mysqli_real_escape_string($conn,md5($_POST["signup_lozinka"]));
  $clozinka = mysqli_real_escape_string($conn,md5($_POST["signup_confirm_lozinka"])); // md5 je enkripcija za sifru

  //$check_email proverava da li u bazi postoji uneti email
$check_email = mysqli_num_rows(mysqli_query($conn,"SELECT email FROM korisnici WHERE email='$email'"));  

  if($lozinka !== $clozinka){
     echo "<script>alert('lozinka did not match.');</script>";
  }
  elseif($check_email > 0){
    echo "<script>alert('Email already exists in our database.');</script>";
  }
  else{
    $sql = "INSERT INTO korisnici(imePrezime, email, lozinka) VALUES ('$imePrezime','$email','$lozinka')";
    $result = mysqli_query($conn,$sql);
    if($result){
      $_POST["signup_imePrezime"] = "";
      $_POST["signup_email"] = "";
      $_POST["signup_lozinka"] = "";
      $_POST["signup_confirm_lozinka"] = "";

      echo "<script>alert('User registration successfully');</script>";
    }
    else{
      echo "<script>alert('User registration failed');</script>";
    }
  }
}



if(isset($_POST["signin"])){
  $email = mysqli_real_escape_string($conn,$_POST["email"]);
  $lozinka = mysqli_real_escape_string($conn,md5($_POST["lozinka"]));


  //$check_email proverava da li u bazi postoji uneti email
$check_email = mysqli_query($conn,"SELECT userId FROM korisnici WHERE email='$email' AND lozinka = '$lozinka'");  

    if(mysqli_num_rows($check_email) > 0){
      $row = mysqli_fetch_assoc($check_email);
      $_SESSION["userId"] = $row['userId'];
      header("Location: welcome.php");
    }else{
      echo "<script>alert('Login details are incorrect. Please try again');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css" />
    <title>Dobro došli!</title>
</head>

<body>
    
    <div class="container">
    
        <div class="forms-container">
        <img src="img/login.jpg" class="image" alt="" />
            <div class="signin-signup">

                <!-- sign in form -->
                <form action="" class="sign-in-form" method="post">
                    <h2 class="title">Sign in</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Email" name="email" value="<?php echo $_POST["email"]; ?>"
                            required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Lozinka" name="lozinka"
                            value="<?php echo $_POST["lozinka"]; ?>" required />
                    </div>
              
                <input type="submit" value="Login" name="signin" class="btn solid" />
                    <p class="social-text">Or Sign in with social platforms</p>
                    <div class="social-media">
                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>


                        
                    </div>
                   <br>
                   <p style="color: #ff6fb7" id="p1">"Beauty is being the best possible version of yourself, inside and out."</p>
                    <p style="color: #ff6fb7" id="p2"> — Audrey Hepburn</p>
                </form>


                <!-- sign up form -->
                <form action="" class="sign-up-form" method="post">
                    <h2 class="title">Sign up</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <!-- value predstavlja vrednost koja ce biti upisana u poljima nakon submitovanja forme-->
                        <input type="text" placeholder="Ime i prezime" name="signup_imePrezime"
                            value="<?php echo $_POST["signup_imePrezime"]; ?>" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Email" name="signup_email"
                            value="<?php echo $_POST["signup_email"]; ?> " required />
                    </div>
                    <div class=" input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Lozinka" name="signup_lozinka"
                            value="<?php echo $_POST["signup_lozinka"]; ?>" required />
                    </div>
                    <div class=" input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Potvrdite lozinku" name="signup_confirm_lozinka"
                            value="<?php echo $_POST["signup_confirm_lozinka"]; ?>" required />
                    </div>
                    <input type="submit" class="btn solid" name="signup" value="Sign up" />
                    <p class="social-text">Or Sign up with social platforms</p>
                    <div class="social-media">

                        <a href="#" class="social-icon">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                        <a href="#" class="social-icon">
                            <i class="fab fa-linkedin-in"></i>
                        </a>

                    </div>

                </form>
            </div>
        </div>

        <div class="panels-container">
            
            <div class="panel left-panel">
            <img src="img/logo1.png" class="image" alt=""/>
                <div class="content">
                   
                    <h3 style="color: #444">Novi ste ovde?</h3>
                    <br>
                    
                    <button class="btn transparent" id="sign-up-btn" style="color: #ff6fb7; border: solid #fff">
                        Sign up
                    </button>
                </div>
               
                

            </div>
            <div class="panel right-panel">
                <div class="content">
                  
                    <h3 style="color: #444">Već ste nas posetili?</h3>
                    <br>
                    <button class="btn transparent" id="sign-in-btn" style="color: #ff6fb7; border: solid #fff">
                        Sign in
                    </button>
                </div>
                <img src="img/logo1.png" class="image" alt="" />
            </div>
        </div>


    </div>



    <script src="app.js"></script>
</body>

</html>