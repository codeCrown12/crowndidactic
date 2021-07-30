<?php
session_start();
include_once ('../connection.php');
include_once ('../functions.php');

if($_SESSION['ad_uname'] == ""){
    header("location: login");
}

if (isset($_GET['sch_email'])) {
    $email = $_GET['sch_email'];
    $query = "SELECT * FROM basicusers WHERE email = '$email'";
    $result = $connection->query($query);
    if (!$result) {
      die($connection->error);
      $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
      <strong>Sorry!</strong> Error in connection
      <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
      </button>
    </div>";
    }
    else{
      $row = $result->fetch_array(MYSQLI_ASSOC);
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Details</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/mystyle.css">
  <style>
      .nav-logo{
          border-radius: 50%;
          border: 1px solid #ccc;
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
            <h1 class="m-0">User Details</h1>
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
          <div class="col-md-9 col-sm-12">
            <div class="card">
                <div class="card-header text-center bg-white">
  <div class="header">
  <img width="100" class="nav-logo" src="<?php echo "../MainDashboard/".$row['profileimg'];?>" alt="">
  </div>
  </div>
                <div class="card-body">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label>School Name</label>
      <input type="text" class="form-control" value="<?php echo $row['Name'] ?>" readonly>
    </div>
    <div class="form-group col-md-6">
      <label>Category</label>
      <input type="text" class="form-control" value="<?php echo $row['category'] ?>" readonly>
    </div>
  </div>
  <div class="form-group">
    <label>Email</label>
    <input type="text" class="form-control" value="<?php echo $row['email'] ?>" readonly>
  </div>
  <div class="form-group">
    <label>Address</label>
    <input type="text" class="form-control" value="<?php echo $row['address'] ?>" readonly>
  </div>
  <div class="form-row">
  <div class="form-group col-md-6">
      <label>Mobile</label>
      <input type="text" class="form-control" value="<?php echo $row['mobile'] ?>" readonly>
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Application Date</label>
      <input type="text" class="form-control" value="<?php echo $row['app_date'] ?>" readonly>
    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-6">
      <label>Facebook</label>
      <input type="text" class="form-control" value="<?php echo $row['facebook'] ?>" readonly>
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Instagram</label>
      <input type="text" class="form-control" value="<?php echo $row['instagram'] ?>" readonly>
    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-6">
      <label>Twitter</label>
      <input type="text" class="form-control" value="<?php echo $row['twitter'] ?>" readonly>
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Linkedin</label>
      <input type="text" class="form-control" value="<?php echo $row['linkedin'] ?>" readonly>
    </div>
  </div>
  <div class="form-group">
    <label>Website url</label>
    <input type="text" class="form-control" value="<?php echo $row['weburl'] ?>" readonly>
  </div>
  <div class="form-group">
    <label>Caption text</label>
    <input type="text" class="form-control" value="<?php echo $row['caption_text'] ?>" readonly>
  </div>
  <div class="form-group">
      <label>About</label>
      <Textarea class="form-control" rows="5" readonly><?php echo $row['about'] ?>"</Textarea>
    </div>
    <a href="../onepage/onepage?selector=<?php echo $row['email']?>" class="btn btn-info" target="_blank">View profile site</a>
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
