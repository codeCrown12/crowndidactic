<?php
// error_reporting(E_ALL & ~E_NOTICE);
session_start();
include '../connection.php';
include '../functions.php';
$selector = "";
$errmsg = "";
$date = date('Y');
$fb = "";
$tweet = "";
$ig = "";
$linkln = "";
$web = "";

 // Mailer script
 require_once '../vendor/autoload.php';

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

if($_SESSION['email'] == ""){
  header("location: ../login");
}
else{
  $selector = $_SESSION['email'];
  
  /********* Code to retrieve user details from database **********/
  $query = "SELECT facebook, instagram, twitter, linkedin, weburl FROM basicusers WHERE email = '$selector' ";
  $user_result = $connection->query($query);
  if(!$user_result){
    die ($connection->error);
  } 
  else {
    $user_record = $user_result->fetch_array(MYSQLI_ASSOC);
    $fb = $user_record['facebook'];
    $tweet = $user_record['twitter'];
    $ig =  $user_record['instagram'];
    $linkln = $user_record['linkedin'];
    $web = $user_record['weburl'];
  }
  /* End of data retrieval code */


   //Snippet to update social media links
   if(isset($_POST['btn_add'])){
     $facebook = check_string($connection, $_POST['facebook']);
     $twitter = check_string($connection, $_POST['twitter']);
     $instagram =  check_string($connection, $_POST['instagram']);
     $linkedin = check_string($connection, $_POST['linkedin']);
     $weburl = check_string($connection, $_POST['weburl']);
     if(empty($facebook) || empty($twitter) || empty($instagram) || empty($linkedin) || empty($weburl)){
       $errmsg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
       <strong>Error!</strong> Some fields are empty
       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'>&times;</span>
       </button>
     </div>";
     }
     else{
       $upd_query = "UPDATE basicusers SET facebook = ?, instagram = ?, twitter = ?, linkedin = ?,  weburl = ? WHERE email = '$selector'";
       $upd_result = $connection->prepare($upd_query);
       $upd_result->bind_param("sssss", $facebook, $instagram, $twitter, $linkedin, $weburl);
       if(!$upd_result->execute()){
         die($connection->connect_error);
         $errmsg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
         <strong>Sorry!</strong> Error in connection
         <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
           <span aria-hidden='true'>&times;</span>
         </button>
       </div>";
       }
       else{
        $errmsg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
         Update successful
         <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
           <span aria-hidden='true'>&times;</span>
         </button>
       </div>";
        header("Refresh:1");
       }
     }
   }


   //Snippet to change email address
   if(isset($_POST['changemail'])){
    $newmail = check_string($connection, $_POST['newemail']);
    if (email_exists($newmail)) {
        $errmsg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Error!</strong> Email already exists
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    }
    elseif($newmail == ""){
      $errmsg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Error!</strong> Field is required
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
    }
    else{
    //   $mail->AddEmbeddedImage("../images/crownEdlogo.png", "my-logo", "crownEdlogo.png");
      $pin = gen_pin();
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
              <h2 style='font-family: Raleway, sans-serif;'>Change of email confirmation</h2>
              <p><strong>Hello Didactian</strong>. We just received a request from $selector to change their email address. Please if this was not you, kindly ignore this email.
              (Do not reply to this mail).
              </p>
              <br>Your verification code is:
                <h2>$pin</h2>
          </div>
      </div>
      <p style='text-align: center;'><small><span style='color: rgb(114, 113, 113);'>&copy; $date </span><a href='https://www.crowndidactic.com' target='_blank'>Crowndidactic</a></small></p>
      </body>
      </html>";
      $mail->setFrom('info@crowndidactic.com', 'Crowndidactic');
      $mail->addAddress($newmail);
      $mail->isHTML(true);
      $mail->Subject = "Email verification";
      
      if($mail->send()){
          $_SESSION['epin'] = $pin;
        $errmsg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
       <strong>Success!</strong> Verification link has been sent to your new email. You will be logged out in 3s
       <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
         <span aria-hidden='true'>&times;</span>
       </button>
     </div>";
        $enc_email = urlencode(base64_encode($selector));
        $enc_nmail = urlencode(base64_encode($newmail));
        unset($_SESSION['email']);
        header( "Refresh:3; url=../changemailverified?selector=$enc_email&n_sel=$enc_nmail", true, 303);
      }  
    else{
      $errmsg =  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Sorry!</strong> Error in connection. Unable to send mail
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>"; 
    }
    }
  }


  //Snippet to change password
  if (isset($_POST['changepass'])) {
    $pass1 = check_string($connection, $_POST['passone']);
    $pass2 = check_string($connection, $_POST['passtwo']);
    if ($pass1 == "" || $pass2 == "") {
      $errmsg =  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Sorry!</strong> All fields are required.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>"; 
    }
    elseif ($pass1 != $pass2) {
      $errmsg =  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Sorry!</strong> Passwords do not match.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>"; 
    }
    else{
      $query = "SELECT passkey FROM basicusers WHERE email = '$selector'";
      $result = $connection->query($query);
      if (!$result) {
        die($connection->error);
        $errmsg =  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Sorry!</strong> Passwords do not match.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }
      else{
        $data = $result->fetch_array(MYSQLI_ASSOC);
        $checkpass = password_verify($pass1, $data['passkey']);
        if (!$checkpass) {
          $errmsg =  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Sorry!</strong> Invalid password.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
        </div>";
        }
        else{
        //   $mail->AddEmbeddedImage("../images/crownEdlogo.png", "my-logo", "crownEdlogo.png");
        $encodemail = urlencode(base64_encode($selector));
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
                  <p><strong>Hello Didactian</strong>. We just received a request from $selector to change their password. Please if this was not you, kindly ignore this email.
                  (Do not reply to this mail).
                  </p>
                  <a href='https://crowndidactic.com/forgotpassword?selector=$encodemail' target='_blank' style='text-decoration: none;text-align: center;'>
                              <div style='background-color: #614385;color: white;padding: 10px;border-radius: 5px;margin-bottom: 10px;width: 40%;margin-left: auto;margin-right: auto;'>
                                  Change password
                              </div>
                          </a>
                  <p>Or copy and paste the link below in your browser if the button does not work.<br> https://crowndidactic.com/forgotpassword?selector=$encodemail</p>
              </div>
          </div>
          <p style='text-align: center;'><small><span style='color: rgb(114, 113, 113);'>&copy; $date </span><a href='https://www.crowndidactic.com' target='_blank'>Crowndidactic</a></small></p>
          </body>
          </html>";
          $mail->setFrom('info@crowndidactic.com', 'Crowndidactic');
          $mail->addAddress($selector);
          $mail->isHTML(true);
          $mail->Subject = "Password change";
          if($mail->send()){
            $errmsg = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
           <strong>Success!</strong> Verification link has been sent to your email. You will be logged out in 4s
           <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
             <span aria-hidden='true'>&times;</span>
           </button>
         </div>";
            header( "Refresh:4; url=../logout.php", true, 303);
          }  
        else{
          $errmsg =  "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          <strong>Sorry!</strong> Error in connection. Unable to send mail
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>"; 
        }
        }
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
  <title>Crowndidactic | Settings</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/mystyle.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php include 'navbar.php';?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php include 'sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Settings</h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-9 col-sm-12">
          <?php
          if($errmsg != "") { 
              echo $errmsg;
            }
            ?>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-cogs"></i>
                  &nbsp; Settings
                </h3>
              </div>
              <div class="card-body ">
              
                <!-- Navigation links -->
                <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-content-above-home-tab" data-toggle="pill" href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Email</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-content-above-profile-tab" data-toggle="pill" href="#custom-content-above-profile" role="tab" aria-controls="custom-content-above-profile" aria-selected="false">Password</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-content-above-messages-tab" data-toggle="pill" href="#custom-content-above-messages" role="tab" aria-controls="custom-content-above-messages" aria-selected="false">Social links</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-content-above-apps-tab" data-toggle="pill" href="#custom-content-above-apps" role="tab" aria-controls="custom-content-above-apps" aria-selected="false">General</a>
                  </li>
                </ul>
                <!-- End of navigation links -->


                
                <div class="tab-content" id="custom-content-above-tabContent">

                <!-- Email change section -->
                  <div class="tab-pane fade show active" id="custom-content-above-home" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                    <form action="settings" method="POST" class="mt-3">
                      <div class="form-group">
                        <p><strong>Note:</strong> Email will not be changed until it is verified via the link we will send to the new email address provided by you.</p>
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" name="newemail" class="form-control" id="exampleInputEmail1" placeholder="Enter new email">
                      </div>
                      <button type="submit" name="changemail" class="btn btn-primary">Change</button>
                    </form>
                  </div>
                  <!-- End of email change section -->



                  <!-- Password change section -->
                  <div class="tab-pane fade" id="custom-content-above-profile" role="tabpanel" aria-labelledby="custom-content-above-profile-tab">
                  <form action="settings" class="mt-3" method="POST">
                    <div class="form-group">
                      <p>Password will not be changed until it is verified by email. You will receive a message to your current account's email address.</p>
                      <label for="exampleInputEmail1">Password</label>
                      <input type="password" name="passone" class="form-control" id="exampleInputEmail1" placeholder="Enter current password">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Confirm Password</label>
                      <input type="password" name="passtwo" class="form-control" id="exampleInputEmail1" placeholder="Confirm current password">
                    </div>
                    <button type="submit" name="changepass" class="btn btn-primary">Change</button>
                  </form>
                  </div>
                  <!-- End of password change section -->
                  


                  <!-- Social links section -->
                  
                  <div class="tab-pane fade" id="custom-content-above-messages" role="tabpanel" aria-labelledby="custom-content-above-messages-tab">
                     <form action="settings" class="mt-3" method="POST">
                      <div class="form-group">
                        <p>Provide links to your social media accounts and website</p>
                        <label for="exampleInputEmail1">facebook</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="facebook" placeholder="" value="<?php echo $fb?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail2">Twitter</label>
                        <input type="text" class="form-control" id="exampleInputEmail2" name="twitter" placeholder="Twitter username"  value="<?php echo $tweet?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">Instagram</label>
                        <input type="text" class="form-control" id="exampleInputEmail3" name="instagram" placeholder="instagram username" value="<?php echo $ig;?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail4">linkedin</label>
                        <input type="text" class="form-control" id="exampleInputEmail4" name="linkedin" placeholder="linkedin username" value="<?php echo $linkln?>">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail5">Official website url (If available)</label>
                        <input type="text" class="form-control" id="exampleInputEmail5" placeholder="website url" name="weburl" value="<?php echo $web?>">
                      </div>
                      <input type="submit" name="btn_add" class="btn btn-primary" value="Save changes">                     
                      </form>
                  </div>
                  <!-- End of social links section -->

                  


                  <div class="tab-pane fade" id="custom-content-above-apps" role="tabpanel" aria-labelledby="custom-content-above-apps-tab">
                  <?php 
                  $frm_query = "SELECT applications FROM basicusers WHERE email = '$selector'";
                  $frm_res = $connection->query($frm_query);
                  if($frm_res){
                    $row = $frm_res->fetch_array(MYSQLI_ASSOC);
                  }
                  ?>
                  
                  <form action="settings" method="POST" class="mt-3">
                  <h4 class="mt-4">Application form</h4>
                  <div class="form-group" style="border: solid #ccc 1px;padding: 10px;border-radius: 5px;">
                    <div class="custom-control custom-switch">
                      <input type="checkbox" name="app_form" <?php if($row['applications'] == "On"){echo "checked";}?> value="<?php echo $row['applications'] ?>" class="custom-control-input" id="customSwitch1">
                      <label class="custom-control-label" for="customSwitch1">Enable applications</label>
                    </div>
                  </div>
                  </form>
                  <h4 class="mt-4">Danger Zone</h4>
                  <div class="form-row" style="border: solid #ccc 1px;padding: 10px;border-radius: 5px;">
                  <div class="form-group col-md-9">
                    <strong>Delete Account</strong><br>
                    <small>(Warning! Deleting your account your account will erase all your school/personal data.)</small>
                  </div>
                  <div class="form-group col-md- mt-3">
                    <a href="verifypass.php" class="btn btn-danger">Delete account</a>
                  </div>
                </div>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <!-- <aside class="control-sidebar control-sidebar-dark">
   Control sidebar content goes here
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside> -->
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <?php include 'footer.php'; ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/modal.js"></script>
<script>
$(function () {
  bsCustomFileInput.init();
});
$(document).ready(function(){
  $('#customSwitch1').click(function(e){
    var value = e.target.value
    $.ajax({
                type: 'POST',
                url: 'appformswitch.php',
                data: 'switch='+value
              })
              .done(function(response){
                alert(response)
              })
              .fail(function(response){
                alert(response)
              })
  })
})
</script>
</body>
</html>
