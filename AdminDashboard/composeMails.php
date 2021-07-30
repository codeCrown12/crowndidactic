<?php
session_start();

include '../vendor/autoload.php';
include '../functions.php';
include '../connection.php';

if($_SESSION['ad_uname'] == ""){
    header("location: login");
}

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

$selector = "";
$sch_email = "";
$info = "";
$sch_name = "";
$status = "";

$_SESSION['admin'] = "admin";
if($_SESSION['admin'] == ""){
  header("location: ../login.php");
}
else{
  $selector = $_SESSION['admin'];
  

  //Email sending form processing code block
  if (isset($_GET['sch_id'])) {
    $sch_email = $_GET['sch_id'];
  }
  if (isset($_GET['status'])) {
    $status = $_GET['status'];
  }

  if (isset($_POST['send_mail'])) {
    $subject = $_POST['subject'];
    $msg = $_POST['msg_body'];

    //check if fields are empty
    if ($subject == "" || $msg == "") {
      $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Error!</strong> All fields are required
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
    }
    //end of check

    else {
    /*-----------------   Snippet to send email       ------------*/
    $mail->setFrom('support@crowndidactic.com', "Crowndidactic");

    //check if mail is to be sent to a single applicant or all the applicants
    if ($sch_email != "") {
      $mail->addBCC($sch_email);
    }
    else if ($status != "" && $status == "active") {
      $query = "SELECT email FROM basicusers WHERE Status = 'Active'";
      $result = $connection->query($query);
      if (!$result) {
        die($connection->error);
        $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Error!</strong> Unable to connect temporariiy
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }
      else {
        $num_rows = $result->num_rows;
        for ($i=0; $i < $num_rows; $i++) { 
          $result->data_seek($i);
          $row = $result->fetch_array(MYSQLI_ASSOC);
          $mail->addBCC($row['email']);
        }
      }
    }
    else if ($status != "" && $status == "inactive") {
      $query = "SELECT email FROM basicusers WHERE Status = 'Inactive'";
      $result = $connection->query($query);
      if (!$result) {
        die($connection->error);
        $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Error!</strong> Unable to connect temporariiy
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }
      else {
        $num_rows = $result->num_rows;
        for ($i=0; $i < $num_rows; $i++) { 
          $result->data_seek($i);
          $row = $result->fetch_array(MYSQLI_ASSOC);
          $mail->addBCC($row['email']);
        }
      }
    }
    else {
      $query = "SELECT email FROM basicusers";
      $result = $connection->query($query);
      if (!$result) {
        die($connection->error);
        $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Error!</strong> Unable to connect temporariiy
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }
      else {
        $num_rows = $result->num_rows;
        for ($i=0; $i < $num_rows; $i++) { 
          $result->data_seek($i);
          $row = $result->fetch_array(MYSQLI_ASSOC);
          $mail->addBCC($row['email']);
        }
      }
    }
    //End of code block to check if mail is to be sent to a single applicant or all the applicants

    $mail->isHTML(true);
    // $mail->AddEmbeddedImage("../images/crownEdlogo.png", "my-logo", "crownEdlogo.png");
    $mail->Subject = $subject;
    $mail->Body = "<!DOCTYPE html>
    <html lang='en'>
    <head>
      <meta charset='UTF-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <title>Message</title>
    </head>
    <body style='background-color: #f8f9fa;padding-bottom: 10px;'>
    <div style='border: solid #fff 1px;width: 80%;padding: 9px;margin-left: auto;margin-right: auto;border-radius: 5px;background-color: white;'>
        <div style='text-align: center;'>
            $msg
        </div>
    </div>
    <p style='text-align: center;'><small><span style='color: rgb(114, 113, 113);'>Powered by </span><a href='https://www.crowndidactic.com/' target='_blank'>Crowndidactic</a></small></p>
    <p style='text-align: center;'><small><span style='color: rgb(114, 113, 113);'></span><a href='https://www.crowndidactic.com/Terms/terms' target='_blank'>Privacy policy</a></small></p>
    </body>
    </html>";
    if($mail->send()){
      $info = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Email sent successfully.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    }  
    else{
      $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
        <strong>Error!</strong> Unable to send email temporarily.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
    }
    }
    //End of form processing code block
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<style>
.btnrow{
  display: flex;
  flex-direction: row;
}
.mailbtn{
  margin-right: 5px;
}
</style>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Send message</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- summernot style -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
  <link rel="stylesheet" href="dist/css/mystyle.css">
  <style>
    .btnx{
      color: white !important;
    }
    .btnx:hover{
      color: white !important;
    }
  </style>
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
            <h1 class="m-0">Compose email</h1>
          </div><!-- /.col -->
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
          if ($info != "") {
            echo $info;
          }
          ?>
      </div>
      </div>
      <div class="row justify-content-center">
          <div class="col-md-9 col-sm-12">
          <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Compose New Message</h3>
              </div>
              <!-- /.card-header -->
              <form action="composeMails.php<?php if ($sch_email != "") {
                echo "?sch_id=".$sch_email;
              }
              elseif ($status != "") {
                echo "?status=".$status;
              }
              ?>" method="POST" enctype="multipart/form-data">
              <div class="card-body">
              <div class="form-group">
              <input class="form-control" placeholder="To:" readonly value="To: <?php if ($sch_email != "") {
                    echo " ".$sch_email;
                  }
                  elseif ($status != "" && $status == "active") {
                    echo "All active schools";
                  }
                  elseif ($status != "" && $status == "inactive") {
                    echo "All inactive schools";
                  } 
                  else {
                    echo " All schools";
                  }
                  ?>">
              </div>
                <div class="form-group">
                  <input class="form-control" placeholder="Subject:" name="subject">
                </div>
                <div class="form-group">
                    <textarea id="compose-textarea" name="msg_body" class="form-control"></textarea>
                </div>
                <!-- <div class="form-group">
                  <label>Add attachment</label>
                  <input type="file" name="myfiles" multiple class="form-control-file">
                </div> -->
                <div class="float-right">
                  <button type="submit" name="send_mail" class="btn btn-primary"><i class="far fa-envelope"></i>&nbsp; Send</button>
                </div>
                </div>
              <!-- /.card-body -->
              </form>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
        <?php include 'modal.php';?>
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
<!-- AdminLTE App -->
<script src="dist/js/modal.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Summernote -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(document).ready(function () {
   
    //Add text editor
    //  $('#compose-textarea').summernote()
  $('#compose-textarea').summernote({
  toolbar: [
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['fontname', ['fontname']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['insert', ['link']],
  ],
  height: 300,
});
}); 
</script>
</body>
</html>
