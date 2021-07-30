<?php
session_start();

include '../connection.php';
include '../functions.php';
$selector = "";
$info = "";

if($_SESSION['email'] == ""){
  header("location: ../login");
}
else{
    $selector = $_SESSION['email'];
    if (isset($_POST['confirm'])) {
        $pass = check_string($connection, $_POST['pass']);
        if ($pass == "") {
            $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      Field is required.
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
        }
        else{
            $query = "SELECT email, passkey FROM basicusers WHERE email = '$selector'";
        $result = $connection->query($query);
        if ($result) {
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $checkpass = password_verify($pass, $row['passkey']);
            if ($checkpass) {
                header("Location: DeleteAcct.php");
            }
            else $info ="<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      Invalid password.
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
  <title>Verify password</title>

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
            <h1 class="m-0">Verfiy password</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="row justify-content-center">
          <div class="col-md-7">
          <?php
            if ($info != "") {
                echo $info;
            } 
          
          ?>
            <div class="card">
                <div class="card-body">
                <form action="verifypass.php" method="POST">
  <div class="form-group">
    <label for="inputAddress">Password</label>
    <input type="password" class="form-control" id="inputAddress" name="pass" placeholder="Verify password">
    <small>(In order to delete your account we need to know it's you)</small>
  </div>
  <a href="settings.php" class="btn btn-outline-success">Cancel</a>
  <button type="submit" name="confirm" class="btn btn-danger">Confirm</button>
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
