<?php
session_start();
include '../connection.php';
include '../functions.php';


if($_SESSION['ad_uname'] == ""){
    header("location: login");
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
  <style>
    .highlight{
      color: red;
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
            <h1 class="m-0">Settings</h1>
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
          <div class="col-md-8 col-sm-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-cogs"></i>
                   Personal Settings
                </h3>
              </div>
              <div class="card-body ">
                <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-content-above-home-tab" data-toggle="pill" href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Username</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-content-above-profile-tab" data-toggle="pill" href="#custom-content-above-profile" role="tab" aria-controls="custom-content-above-profile" aria-selected="false">Password</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-content-above-details-tab" data-toggle="pill" href="#custom-content-above-details" role="tab" aria-controls="custom-content-above-details" aria-selected="false">Details</a>
                  </li>
                </ul>
                <div class="tab-content" id="custom-content-above-tabContent">
                  <div class="tab-pane fade show active" id="custom-content-above-home" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                    <form action="" class="mt-3">
                      <div class="form-group">
                        <p>Update your username via the field below</p>
                        <label for="exampleInputEmail1">Username</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Username">
                      </div>
                      <button type="submit" class="btn btn-primary">Change</button>
                    </form>
                  </div>
                  <div class="tab-pane fade" id="custom-content-above-profile" role="tabpanel" aria-labelledby="custom-content-above-profile-tab">
                  <form action="" class="mt-3">
                    <div class="form-group">
                      <p>Password will not be changed until it is verified by email. You will receive a message to your current account email address.</p>
                      <label for="exampleInputEmail1">Password</label>
                      <input type="password" class="form-control" id="exampleInputEmail1" placeholder="Enter password">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Confirm Password</label>
                      <input type="password" class="form-control" id="exampleInputEmail1" placeholder="Confirm password">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">New Password</label>
                      <input type="password" class="form-control" id="exampleInputEmail1" placeholder="New password">
                    </div>
                    <button type="submit" class="btn btn-primary">Change</button>
                  </form>
                  </div>
                  <div class="tab-pane fade" id="custom-content-above-details" role="tabpanel" aria-labelledby="custom-content-above-details-tab">
                  <form action="" class="mt-3">
                    <div class="form-group">
                      <label>Firstname</label>
                      <input type="text" class="form-control" >
                    </div>
                    <div class="form-group">
                      <label>Lastname</label>
                      <input type="text" class="form-control" >
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="text" class="form-control" >
                    </div>
                    <div class="form-group">
                      <label>Mobile</label>
                      <input type="text" class="form-control" >
                    </div>
                    <div class="form-group">
                      <label>Address</label>
                      <input type="text" class="form-control" >
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                  </form>
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
