<?php
session_start();
include_once ('connection.php');
include_once ('functions.php');

require_once 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function update_email($connection, $email, $newemail){
    $query = "UPDATE basicusers SET email = ? WHERE email = '$email'";
    $result = $connection->prepare($query);
    $result->bind_param("s", $newemail);
    if(!$result->execute()){
        return false;
      } 
      else{
          return true;
      }
}

function activate_user($connection, $email){
    $stat = "Active";
    $query = "UPDATE basicusers SET Status = ? WHERE email = '$email'";
    $result = $connection->prepare($query);
    $result->bind_param("s", $stat);
    if(!$result->execute()){
        return false;
      }
      else{
          return true;
      }
}



$pin = $_SESSION['epin'];
$email = "";
$errormsg = "";
$enc_email = "";
$newemail = "";
$enc_newemail = "";
$getstr = "";

if (isset($_GET['selector'])) {
    $email = base64_decode(urldecode($_GET['selector']));
    $enc_email = $_GET['selector'];
    $getstr = "?selector=$enc_email";
}

if (isset($_GET['selector']) && isset($_GET['n_sel'])) {
    $email = base64_decode(urldecode($_GET['selector']));
    $enc_email = $_GET['selector'];
    $newemail = base64_decode(urldecode($_GET['n_sel']));
    $enc_newemail = $_GET['n_sel'];
    $getstr = "?selector=$enc_email&n_sel=$enc_newemail";
}

if(isset($_POST['request'])){
    $_SESSION['epin'] = gen_pin();
    $pin = $_SESSION['epin'];
    
          $mail = new PHPMailer();
          $mail->isSMTP();
          $mail->Host = 'mail.crowndidactic.com';
          $mail->SMTPAuth = true;
          $mail->Username = 'info@crowndidactic.com'; 
          $mail->Password = 'Passw0rdx123#';
          $mail->SMTPSecure = 'ssl';
          $mail->Port = 465;
          $mail->setFrom('info@crowndidactic.com', "Crowndidactic");
          if(isset($_GET['selector']) && isset($_GET['n_sel'])){
            $mail->addAddress($newemail);  
          }
          else{
              $mail->addAddress($email); 
          }
          $mail->isHTML(true);
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
                  <h2 style='font-family: Raleway, sans-serif;'>Email Verification</h2>
                  <p><strong>Hello Didactian</strong>.
                  <br>Your new verification code is:
                  <h3>$pin</h3>
                  (Do not reply to this mail).
                  </p>
              </div>
          </div>
          <p style='text-align: center;'><small><span style='color: rgb(114, 113, 113);'>&copy; $date </span><a href='https://www.crowndidactic.com' target='_blank'>Crowndidactic</a></small></p>
          </body>
          </html>";
          if($mail->send()){
            $errormsg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    Your new pin has been sent to your email.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
          }  
        else{
          $errormsg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    Error in sending new code. 
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
        }
}

if(isset($_POST['submit'])){
    $key = check_string($connection,$_POST['key']);
    if($key == ""){
        $errormsg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    Field is required.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
    }
    else if($key != $pin){
        $errormsg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    Invalid pin
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
    }
    else if($email == ""){
         $errormsg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    Email not valid 
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
    }
    else if($newemail != ""){
        $bool = update_email($connection, $email, $newemail);
        if (!$bool) {
            $errormsg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    Error in connection 
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
        }
        else{
            if(update_gal_key($connection, $email, $newemail) && update_faqs_key($connection, $email, $newemail) && update_apps_key($connection, $email, $newemail) && update_feedbacks_key($connection, $email, $newemail) && update_courses_key($connection, $email, $newemail)){
             $errormsg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            Verification successful <a href='login'>Login to account</a> 
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
          unset($_SESSION['epin']);   
             
         }
            
        }
    }
    else{
        $sec_bool = activate_user($connection, $email);
        if (!$sec_bool) {
            $errormsg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Error in connection 
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
        }
        else{
            $errormsg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            Verification successful <a href='login'>Login to account</a> 
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
          unset($_SESSION['epin']);
        }
    
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Verify Pin</title>

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
    <a href="index.php" class="h1"><img src="images/crownEdLogo.png?randomurl=<?php echo rand();?>" width="200" alt=""></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Enter the pin we sent to your email address</p>
      <form action="changemailverified<?php echo $getstr ?>" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="key" placeholder="Enter pin here">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-key"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Verify Pin</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <div class="card-footer">
        <form action="changemailverified<?php echo $getstr ?>" method="POST">
          <p class="">
        <button class="btn btn-link" type="submit" name="request">Resend code</button>
      </p>
      </form>
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