<?php
session_start();
require_once '../connection.php';
require_once '../functions.php';


if($_SESSION['ad_uname'] == ""){
    header("location: login");
}


// Insert new user
$errormsg = '';
$date = date('Y');
if(isset($_POST['add'])){
    $fname = check_string($connection,$_POST['fname']);
    $lname = check_string($connection,$_POST['lname']);
    $email = check_string($connection,$_POST['email']);
    $addr = check_string($connection,$_POST['address']);
    $mobile = check_string($connection,$_POST['mobile']);
    $uname = check_string($connection,$_POST['uname']);
    if($fname == "" || $lname == "" || $email == "" || $addr == "" || $mobile == "" || $uname == ""){
        $errormsg = "<p style='color: red;' class='mt-3'><i class='fas fa-exclamation-circle'></i> All fields are required</p>";
    }
    
    else if(admin_email_exists($email) == true){
        $errormsg = "<p style='color: red;' class='mt-3'><i class='fas fa-exclamation-circle'></i> Email already exists</p>";
    }
    else if(uname_exists($uname) == true){
        $errormsg = "<p style='color: red;' class='mt-3'><i class='fas fa-exclamation-circle'></i> Username already exists</p>";
    }
    else if (preg_match('/[\^£$%&*()}{@#~?><>,|=_+¬-]/', $name)){
        $errormsg = "<p style='color: red;' class='mt-3'><i class='fas fa-exclamation-circle'></i> Some illegal characters found</p>";
    }
    else{
        $pass = "1234";
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $query = "INSERT INTO admin_users(firstname, lastname, email, mobile, address, username, passkey) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $result = $connection->prepare($query);
        $result->bind_param("sssssss", $fname, $lname, $email, $mobile, $addr, $uname, $pass);
        if(!$result->execute()){
            die($connection->connect_error);
            $errormsg = "<p style='color: red;' class='mt-3'><i class='fas fa-exclamation-circle'></i> Error in connection</p>";
        }
        else{
            $errormsg = "<p style='color: green;' class='mt-3'><i class='fas fa-exclamation-circle'></i> User added successfully</p>";
            header("Refresh:1"); 
        }
    }
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crowndidactic | Add User</title>

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
            <h1 class="m-0">Add Member</h1>
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
              <?php
              if($errormsg != ""){
                  echo $errormsg;
              }
              ?>
            <div class="card">
                <div class="card-body">
                <form action="addUser" method="post">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">First Name</label>
      <input type="text" class="form-control" name='fname' id="inputEmail4">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Last Name</label>
      <input type="text" class="form-control" name='lname' id="inputPassword4">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Email</label>
    <input type="email" class="form-control" name='email' id="inputAddress" placeholder="youremail@server.com">
  </div>
  <div class="form-group">
    <label for="inputAddress">Address</label>
    <input type="text" class="form-control" name='address' id="inputAddress" placeholder="1234 Main St">
  </div>
  <div class="form-row">
  <div class="form-group col-md-6">
      <label for="inputEmail4">Mobile</label>
      <input type="text" class="form-control" name='mobile' id="inputEmail4">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Username</label>
      <input type="text" class="form-control" name='uname' id="inputPassword4">
    </div>
  </div>
  <div class="form-group col-md-12">
    <input type="submit" class="btn btn-success" name='add' value="Add user">
  </div>
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
