<?php
session_start();
require_once 'connection.php';
require_once 'functions.php';
$errormsg = "";
if(isset($_POST['login'])){
  $email = check_string($connection, $_POST['email']);
  $pass =  check_string($connection, $_POST['passkey']);

  if($email == "" || $pass == ""){
    $errormsg = "<i class='fas fa-exclamation-circle'></i> All fields are required";
  }
  else{
    $query = "SELECT email, passkey FROM basicusers WHERE email = '$email' AND Status = 'Active'";
    $result = $connection->query($query);
    $rows = $result->num_rows;
    if($rows == 1){
      for($i=0; $i<$rows; $i++){
        $result->data_seek($i);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $check_pass = password_verify($pass, $row['passkey']);
        if($check_pass){
          $_SESSION['email'] = $email;
          header("location: MainDashboard/home");
        }
        else{
          $errormsg = "<i class='fas fa-exclamation-circle'></i> Invalid email or password";
        }
      }
    }
    else $errormsg = "<i class='fas fa-exclamation-circle'></i> Invalid email or password";
  }
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- <meta name="description" content=""> -->
    <!-- <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v4.1.1"> -->
    <title>Login</title>
    <link rel="shortcut icon" type="image/jpg" href="images/favicon.png"/>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/floating-labels/">

    <!-- Bootstrap core CSS -->
<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- font awesome css links -->
<link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/all.css" type="text/css">
<link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/all.min.css" type="text/css">
<link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/brands.css" type="text/css">
<link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/brands.min.css" type="text/css">
<link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/fontawesome.css" type="text/css">
<link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/fontawesome.min.css" type="text/css">
<link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/regular.css" type="text/css">
<link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/regular.min.css" type="text/css">
<link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/solid.css" type="text/css">
<link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/solid.min.css" type="text/css">
<link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/svg-with-js.css" type="text/css">
<link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/svg-with-js.min.css" type="text/css">
<link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/v4-shims.css" type="text/css">
<link rel="stylesheet" href="fontawesome-free-5.13.0-web/css/v4-shims.min.css" type="text/css">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="stylesheets/floating-labels.css" rel="stylesheet">
    <link rel="stylesheet" href="stylesheets/style.css">
  </head>
  <body>
    <form class="form-signin" action="login" method="POST">
  <div class="text-center mb-4">
    <a href="index"><p><img src="images/crownEdLogo.png?randomurl=<?php echo rand();?>" alt="CrownEducation" width="220"></p></a>
  </div>
  <div class="text-center" style="margin-bottom: 10px;"><small style="color: red;"><?php echo $errormsg; ?></small></div>
  <div class="form-label-group">
    <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address" required autofocus name="email">
    <label for="inputEmail">Email address</label>
  </div>

  <div class="form-label-group">
    <input type="password" name="passkey" id="inputPassword" class="form-control" placeholder="Password" required name="password">
    <label for="inputPassword">Password</label>
  </div>
  <button class="btn btn-lg btn-primary btn-block colo" type="submit" name="login">Sign in</button>
  <p class="text-center" style="margin-top: 15px;">New here? <a href="register" style="text-decoration: none;font-size: 15px;">Create an account</a><br><a href="forgotpass" style="text-decoration: none;font-size: 15px;">Forgot password?</a></p>
  <p class="mt-5 mb-3 text-muted text-center" style="font-size: 13px;">&copy; <?php echo date('Y') ?> Crowndidactic</p>
</form>
</body>
</html>
