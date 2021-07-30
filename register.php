<?php
session_start();
include_once ('connection.php');
include_once ('functions.php');

require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Insert new user
$errormsg = '';
$date = date('Y');
if(isset($_POST['signup'])){
    $name = check_string($connection,$_POST['name']);
    $cat =  check_string($connection,$_POST['category']);
    $email = check_string($connection,$_POST['email']);
    $pass1 = check_string($connection,$_POST['passone']);
    $pass2 = check_string($connection,$_POST['passtwo']);
    $pin = gen_pin();
    if($name == "" || $email == "" || $pass1 == "" || $pass2 == "" || $cat == "-- Select category --" || !isset($_POST['terms'])){
        $errormsg = "<p style='color: red;' class='mt-3'><i class='fas fa-exclamation-circle'></i> All fields are required</p>";
    }
    else if(strlen($pass1) > 12){
        $errormsg = "<p style='color: red;' class='mt-3'><i class='fas fa-exclamation-circle'></i> Password should not be more than 12 characters!</p>";
    }
    else if($pass1 != $pass2){
        $errormsg = "<p style='color: red;' class='mt-3'><i class='fas fa-exclamation-circle'></i> Passwords do not match</p>";
    }
    else if(email_exists($email) == true){
        $errormsg = "<p style='color: red;' class='mt-3'><i class='fas fa-exclamation-circle'></i> Email already exists</p>";
    }
    else if (preg_match('/[\^£$%&*()}{@#~?><>,|=_+¬-]/', $name)){
        $errormsg = "<p style='color: red;' class='mt-3'><i class='fas fa-exclamation-circle'></i> Some illegal characters found</p>";
    }
    else{
        $app_date_str = date('Y-m-d');
        $pass1 = password_hash($pass1, PASSWORD_DEFAULT);
        $query = "INSERT INTO basicusers(Name, email, category, passkey, app_date) VALUES (?, ?, ?, ?, ?)";
        $result = $connection->prepare($query);
        $result->bind_param("sssss", $name, $email, $cat, $pass1, $app_date_str);
        if(!$result->execute()){
            die($connection->connect_error);
            $errormsg = "<p style='color: red;' class='mt-3'><i class='fas fa-exclamation-circle'></i> Error in connection</p>";
        }
        else{
             
            // Mailer script
          $mail = new PHPMailer();

          $mail->isSMTP();
          $mail->Host = 'mail.crowndidactic.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'info@crowndidactic.com'; 
          $mail->Password = 'Passw0rdx123#';
          $mail->SMTPSecure = 'ssl';
          $mail->Port = 465;
          $mail->setFrom('info@crowndidactic.com', "Crowndidactic");
          $mail->addAddress($email);
          $mail->isHTML(true);
          $mail->AddEmbeddedImage("../images/crownEdlogo.png", "logo", "crownEdlogo.png");
          $mail->Subject = "Email verification";
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
                  <p><img alt='logo' src='cid:logo' width='45%'></p>
                  <h2 style='font-family: Raleway, sans-serif;'>Email Verification</h2>
                  <p><strong>Hello $name</strong>. Your almost ready to start enjoying top tier advertisement services from Crowndidactic. 
                  In order to complete the registration process, you have to verify your email address.
                  <br>
                  <br>Your verification code is:
                  <h2>$pin</h2>
                  (Do not reply to this mail).
                  </p>
              </div>
          </div>
          <p style='text-align: center;'><small><span style='color: rgb(114, 113, 113);'>&copy; $date </span><a href='https://www.crowndidactic.com' target='_blank'>Crowndidactic</a></small></p>
          </body>
          </html>";
          if($mail->send()){
              $_SESSION['epin'] = $pin;
              $email = urlencode(base64_encode($email));
              $name = urlencode(base64_encode($name));
            $errormsg = "<p style='color: green;' class='mt-3'><i class='fas fa-check-circle'></i> Verification link has been sent to your email address.</p>";
            header( "Refresh:3; url=changemailverified?selector=$email", true, 303);
            // header("Location: changemailverified");
          }  
        else{
          $errormsg = "<p style='color: red;' class='mt-3'><i class='fas fa-exclamation-circle'></i> Error in connection</p>". $mail->ErrorInfo;
        }
        }
    }
    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration</title>
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
<body class="hold-transition register-page">
<div class="register-box">
  <div class="card card-primary card-outline">
    <div class="card-header text-center">
      <a href="index" class="h1"><img src="images/crownEdLogo.png?randomurl=<?php echo rand();?>" width="200" alt=""></a>
      <?php
        if ($errormsg != '') {
          echo $errormsg;
        }
      ?>
    </div>
    <div class="card-body"> 
      <form action="register.php" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Tutor/Institution name" name="name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-school"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
        <select type="email" class="form-control" name="category">
          <option value="-- Select category --">-- Select category --</option>
          <?php
          $querycat = "SELECT category FROM categories";
          $result = $connection->query($querycat);
          if(!$result) die ($connection->error);
          $rows = $result->num_rows;

            for($i=0; $i<$rows; $i++){
                $result->data_seek($i);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                echo "<option value='".$row['category']."'>".$row['category']."</option>";
                }
                $result->close();
                ?>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-stream"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="passone">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Confirm password" name="passtwo">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="Terms/terms" target="_blank">terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <!-- <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </div> -->
          <!-- /.col -->
        </div>
        <div class="row mt-4 mb-4">
          <div class="col-12">
            <input type="submit" name="signup" value="Create account" class="btn btn-block btn-primary bgcrown">
          </div>
        </div>
      </form>
      <a href="login" class="text-center">I already have an account</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
</div>
<!-- /.register-box -->

<!-- jQuery -->
<script src="MainDashboard/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="MainDashboard/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="MainDashboard/dist/js/adminlte.min.js"></script>
</body>
</html>
