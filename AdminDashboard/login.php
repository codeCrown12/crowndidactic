<?php
session_start();
require_once '../connection.php';
require_once '../functions.php';
$errormsg = "";
if(isset($_POST['login'])){
  $uname = check_string($connection, $_POST['uname']);
  $pass =  check_string($connection, $_POST['passkey']);

  if($uname == "" || $pass == ""){
    $errormsg = "<i class='fas fa-exclamation-circle'></i> All fields are required";
  }
  else{
    $query = "SELECT username, passkey FROM admin_users WHERE username = '$uname' AND Status = 'Active'";
    $result = $connection->query($query);
    $rows = $result->num_rows;
    if($rows == 1){
      for($i=0; $i<$rows; $i++){
        $result->data_seek($i);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $check_pass = password_verify($pass, $row['passkey']);
        if($check_pass){
          $_SESSION['ad_uname'] = $uname;
          header("location: dashboard");
        }
        else{
          $errormsg = "<i class='fas fa-exclamation-circle'></i> Invalid username or password";
        }
      }
    }
    else $errormsg = "<i class='fas fa-exclamation-circle'></i> Invalid username or password";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
   <link rel="stylesheet" href="dist/css/mystyle.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="../index"><img src="../images/crownEdLogo.png?randomurl=<?php echo rand();?>" width="200" alt=""></a>
  </div>
  <div class='text-center mb-2' style='color: red;'>
      <?php
  if($errormsg != ""){
      echo $errormsg;
  }
  ?>
  </div>
  
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Admin Dashboard</p>

      <form action="login" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name='uname' placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name='passkey' placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="social-auth-links text-center mb-3">
        <button type='submit' name='login' class="btn btn-block btn-primary">
          Sign in
        </a>
      </div>
      </form>

      
      <!-- /.social-auth-links -->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
