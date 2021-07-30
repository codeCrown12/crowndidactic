<?php
include 'functions.php';
include 'connection.php';
$errmsg = "";
$selector = "";
$key = "";

if (isset($_GET['selector'])) {
  $selector =  $_GET['selector'];
  $decode = base64_decode(urldecode($selector));
  $key = $decode;
  if (!email_exists($key)) {
      header("Location: logout.php");
  }
}

if (isset($_POST['submit'])) {
  $pass1 = check_string($connection, $_POST['passone']);
  $pass2 = check_string($connection, $_POST['passtwo']);
  
  if ($pass1 == "" || $pass2 == "") {
    $errmsg =  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      All fields are required.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>"; 
  }
  elseif ($pass1 != $pass2) {
    $errmsg =  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      Passwords do not match.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>"; 
  }
else{
  $new_pass = password_hash($pass1, PASSWORD_DEFAULT);
  $query = "UPDATE basicusers SET passkey = ? WHERE email = '$key'";
  $result = $connection->prepare($query);
  $result->bind_param("s", $new_pass);
  if(!$result->execute()){
      die($connection->connect_error);
      $errmsg =  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      Unable to update password.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
    }
    else{
      $errmsg =  "<div class='alert alert-success alert-dismissible fade show' role='alert'>
      Password updated successfully.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
    header( "Refresh:2; url=login.php", true, 303);
    } 
}
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Recover Password</title>
  <link rel="shortcut icon" type="image/jpg" href="images/favicon.png"/>
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="MainDashboard/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="MainDashboard/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="MainDashboard/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="MainDashboard/dist/css/mystyle.css">
  <link rel="stylesheet" href="stylesheets/style.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
<?php
if ($errmsg != "") {
  echo $errmsg;
}
?>
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
    <a href="index" class="h1"><img src="images/crownEdLogo.png?randomurl=<?php echo rand();?>" width="200" alt=""></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">You are only one step a way from your new password, recover your password now.</p>
      <form action="forgotpassword?selector=<?php echo $selector ?>" method="post">
        <div class="input-group mb-3">
          <input type="password" name="passone" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="passtwo" class="form-control" placeholder="Confirm Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Change password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mt-3 mb-1">
        <a href="login">Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="MainDashboard/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="MainDashboard/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="MainDashboard/dist/js/adminlte.min.js"></script>
</body>
</html>
