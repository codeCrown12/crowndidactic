<?php
session_start();
include '../functions.php';
include '../connection.php';
$selector = "";
$info = "";
if($_SESSION['email'] == ""){
  header("location: ../login");
}
else {
    $selector = $_SESSION['email'];
    if (isset($_POST['submit'])) {
        $title = check_string($connection, $_POST['title']);
        $msg = check_string($connection, $_POST['msg']);

        if ($title == "" || $msg == "") {
            $info = "<p style='color: red;'>All fields are required</p>";
        }
        else{
            $query = "INSERT INTO delete_reasons (school_email, title, reason) VALUES (?,?,?)";
            $result = $connection->prepare($query);
            $result->bind_param("sss", $selector, $title, $msg);
            if ($result->execute()) {
                if (deactivate_acct($selector, $connection)) {
                    header("Location: ../logout.php");
                }
                else {
                    $info = "<p style='color: red;'>Error in connection</p>";
                }
            }
            else {
                $info = "<p style='color: red;'>Error in connection</p>";
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
  <title>Delete account</title>

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
            <h1 class="m-0">Delete Account</h1>
          </div><!-- /.col -->
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Settings</li>
            </ol>
          </div>/.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="row justify-content-center">
          <div class="col-md-9">
          <?php
            if ($info != "") {
              echo $info;
            }
          ?>
            <div class="card">
                <div class="card-body">
            <form action="DeleteAcct.php" method="POST">
              <div class="form-group">
                <label for="titlefield">Title</label>
                <input type="text" name="title" class="form-control" id="titlefield" placeholder="Title">
              </div>
              <div class="form-group">
                <label for="inputAddress">Reason</label>
                <textarea name="msg" class="form-control" rows="5" placeholder="Tell us why you're deleting your account"></textarea>
              </div>
              <a href="settings.php" class="btn btn-success">Cancel</a>
              <button type="submit" name="submit" class="btn btn-outline-danger">Delete account</button>
            </form>
            </div>
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
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/modal.js"></script>
</body>
</html>
