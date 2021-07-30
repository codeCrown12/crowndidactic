<?php
session_start();
include_once ('../connection.php');
include_once ('../functions.php');
$err_msg = "";
$err_msg_two = "";

if($_SESSION['ad_uname'] == ""){
    header("location: login");
}

// Snippet to select site information from database
$query_one = "SELECT * FROM site_info";
$res_one = $connection->query($query_one);
if (!$res_one) {
    die($connection->error);
    $err_msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    Error in connection.
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
}
else {
  $row_one = $res_one->fetch_array(MYSQLI_ASSOC);
}

//End of snippet


if (isset($_POST['update'])) {
  $address = check_string($connection, $_POST['address']);
  $mobile = check_string($connection, $_POST['mobile']);
  $email = check_string($connection, $_POST['email']);
  $facebook = check_string($connection, $_POST['facebook']);
  $instagram = check_string($connection, $_POST['instagram']);
  $linkedin = check_string($connection, $_POST['linkedin']);
  $twitter = check_string($connection, $_POST['twitter']);

  if ($address == "" || $mobile == "" || $email == "" || $facebook == "" || $instagram == "" || $linkedin == "" || $twitter == "") {
    $err_msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    All fields are required
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
  }
  else{
    $query = "UPDATE site_info SET address = '$address', mobile = '$mobile', email = '$email', facebook = '$facebook', instagram = '$instagram', linkedin = '$linkedin', twitter = '$twitter'";
  $result = $connection->query($query);
  if ($result) {
    header("Refresh:0");
  }
  else{
    die($connection->error);
    $err_msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    Error in connection.
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
  <title>Web settings</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/mystyle.css">
  <style>
  .hide_border{
    border: 0px;
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
            <h1 class="m-0">Site information</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <!-- <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="uploads/defaultimg.png"
                       alt="User profile picture">
                </div>
                <a type="button" class="btn btn-primary btn-block mt-3" data-toggle="modal" data-target="#modal-addphoto"><b>Add logo <i class="fas fa-camera mr-2"></i></b></a>
              </div>
               /.card-body
            </div> -->
            <!-- About information -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Site info</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr> -->

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Address</strong>

                <p class="text-muted"><?php echo $row_one['address'] ?></p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Mobile</strong>

                <p class="text-muted"><?php echo $row_one['mobile'] ?></p>

                <hr>
                <strong><i class="far fa-mail mr-1"></i> Email</strong>

                <p class="text-muted"><?php echo $row_one['email'] ?></p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-md-9">
          <?php
          if ($err_msg != "") {
            echo $err_msg; 
          }
          ?>
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About and Contact information</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="home.php" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Address</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="address"  value="<?php echo $row_one['address'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mobile</label>
                    <input type="tel" class="form-control" id="exampleInputPassword1" name="mobile"  value="<?php echo $row_one['mobile'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Email</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="email"  value="<?php echo $row_one['email'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Facebook</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="facebook" value="<?php echo $row_one['facebook'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">instagram</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="instagram" value="<?php echo $row_one['instagram'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">linkedin</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="linkedin" value="<?php echo $row_one['linkedin'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Twitter</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="twitter" value="<?php echo $row_one['twitter'] ?>">
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="update" class="btn btn-primary">Save changes</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      <!-- /.container-fluid -->
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
  
  </div>
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
</body>
</html>