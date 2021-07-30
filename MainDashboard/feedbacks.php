<?php
session_start();
include_once ('../connection.php');
include_once ('../functions.php');

$selector = "";
$info = "";

if($_SESSION['email'] == ""){
  header("location: ../login");
}
else{
    $selector = $_SESSION['email'];
    if (isset($_POST['fb_send'])) {
        $fb_title = check_string($connection, $_POST['fb_title']);
        $fb_message = check_string($connection, $_POST['fb_message']);
        if ($fb_title == "" || $fb_message == "") {
          $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          <strong>Error!</strong> All fields are required.
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
        }
        else {
          $date = date('Y-m-d H:i A');
          $fb_query = "INSERT INTO feedbacks (school_email, title, message, date) VALUES (?,?,?,?)";
          $fb_res = $connection->prepare($fb_query);
          $fb_res->bind_param("ssss", $selector, $fb_title, $fb_message, $date);
          if (!$fb_res->execute()) {
            die($connection->error);
            $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          <strong>Error!</strong> Unable to send feedback
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
          }
          else {
            $info = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          <strong>Success!</strong> Feedback sent. You will receive a response from us via email.
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
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
  <title>Crowndidactic | feedback</title>

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
            <h1 class="m-0">Feedback</h1>
          </div><!-- /.col -->
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"> Page</li>
            </ol>
          </div>/.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-9 col-sm-12">
        <?php
        if ($info != "") {
            echo $info;
        }
        
        ?>
        <div class="card card-primary">
              <div class="card-header">
                <h4 class="card-title">Send us a message</h4>
              </div>
              <div class="card-body mycard_box">
            <form action="feedbacks.php" method="POST">
            <div class="form-group">
              <input class="form-control" type="text" name="fb_title" placeholder="Feedback Title ">
            </div>
              <div class="form-group">
                  <label><small>(max: 1000 characters)</small></label>
                    <textarea class="form-control" name="fb_message" id="exampleFormControlTextarea1" rows="6" placeholder="Message"></textarea>
                </div>
                <div class="form-group">
                <button type="submit" name="fb_send" class="btn btn-primary ml-auto"><i class="fas fa-edit"></i> Send</button>
                </div>
            </form>
              </div>
            </div>
            <p class="text-center"><a href="feedbackstat" style="text-decoration: underline;">View all previously sent feed backs</a></p>
        </div>
        </div>
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
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- <script src="plugins/toastr/toastr.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
  $(function(){
    $('.toastrDefaultSuccess').click(function() {
      toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
  });
</script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
</body>
</html>