<?php
require_once 'connection.php';
require_once 'functions.php';
$errormsg = "";
$date = date('Y');
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

     $mail = new PHPMailer();
     $mail->isSMTP();
     $mail->Host = 'mail.crowndidactic.com';
     $mail->SMTPAuth = true;
     $mail->Username = 'info@crowndidactic.com'; 
     $mail->Password = 'Passw0rdx123#';
     $mail->SMTPSecure = 'ssl';
     $mail->Port = 465;


if (isset($_POST['submit'])) {
  $email = check_string($connection, $_POST['email']);
  if ($email == "") {
    $errormsg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Error!</strong> Field is required.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
  }
  elseif (!email_exists($email)) {
    $errormsg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Error!</strong> No user with this email.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
  }
  else{
    // $mail->AddEmbeddedImage("images/crownEdlogo.png", "my-logo", "crownEdlogo.png");
    $encodemail = urlencode(base64_encode($email));
    $mail->Body = "<!DOCTYPE html>
    <html lang='en'>
    <head>
      <meta charset='UTF-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <title>Email verification</title>
      <style>
        @media screen and (max-width: 600px){
          .box{
            width: 100%;
          }
        }
      </style>
    </head>
    <body style='background-color: #f8f9fa;padding-bottom: 7px;'>
    <div class='box' style='border: solid #fff 1px;width: 67%;padding: 12px;margin-left: auto;margin-right: auto;border-radius: 5px;background-color: white;'>
        <div style='text-align: center;'>
            <h2 style='font-family: Raleway, sans-serif;'>Change Password</h2>
            <p><strong>Hello Didactian</strong>. We just received a request from $email to change their password. Please if this was not you, kindly ignore this email.
            (Do not reply to this mail).
            </p>
            <a href='https://crowndidactic.com/forgotpassword.php?selector=$encodemail' target='_blank' style='text-decoration: none;text-align: center;'>
                        <div style='background-color: #614385;color: white;padding: 10px;border-radius: 5px;margin-bottom: 10px;width: 40%;margin-left: auto;margin-right: auto;'>
                            Change password
                        </div>
                    </a>
            <p>Or copy and paste the link below in your browser if the button does not work.<br> https://crowndidactic.com/forgotpassword.php?selector=$encodemail</p>
        </div>
    </div>
    <p style='text-align: center;'><small><span style='color: rgb(114, 113, 113);'>&copy; $date </span><a href='https://www.crowndidactic.com' target='_blank'>Crowndidactic</a></small></p>
    </body>
    </html>";
    $mail->setFrom('info@crowndidactic.com', 'Crowndidactic');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "Password change";
    if($mail->send()){
      $errormsg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
     <strong>Success!</strong> Verification link has been sent to your email.
     <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
       <span aria-hidden='true'>&times;</span>
     </button>
   </div>";
    }  
  else{
    $errormsg =  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Sorry!</strong> Error in connection
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>"; 
  }
  }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password</title>
  <link rel="shortcut icon" type="image/jpg" href="images/favicon.png"/>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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
  if ($errormsg != "") {
    echo $errormsg;
  }
?>
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
    <a href="index" class="h1"><img src="images/crownEdLogo.png?randomurl=<?php echo rand();?>" width="200" alt=""></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">You forgot your password? Enter your email to change it.</p>
      <form action="forgotpass.php" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mt-3 mb-1">
        <a href="login.php">Login</a>
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
