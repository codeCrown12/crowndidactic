<?php
session_start();
include_once ('../connection.php');
include_once ('../functions.php');

if($_SESSION['ad_uname'] == ""){
    header("location: login");
}

$info = "";
$id = "";
if (isset($_GET['msg_id'])) {
    $id = $_GET['msg_id'];
    $query = "SELECT delete_reasons.ID, delete_reasons.title, delete_reasons.reason, delete_reasons.date, basicusers.Name, basicusers.email FROM delete_reasons
    INNER JOIN basicusers ON basicusers.email=delete_reasons.school_email WHERE ID = $id";
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
  else{
      header("Location: feedbacks");
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
  <title>View Reason</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
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
            <h1 class="m-0">Mesage</h1>
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

      </div>
      </div>
      <div class="row justify-content-center">
          <div class="col-md-9 col-sm-12">
          <?php
          if ($info != "") {
            echo $info;
          }
          
          $color = "";
          $display = "";
          if($row['Status'] == 'Unread'){
              $color = "danger";
              $display = "inline";
          }
          else if($row['Status'] == 'Read'){
              $color = "success";
              $display = "none";
          }
          ?>
          <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Message body</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <Strong><?php echo $row['Name'] ?></Strong> &nbsp<span><small><?php echo $row['date'] ?></small></span>
              <p><?php echo $row['email'] ?></p><br>
              <h3><?php echo $row['title'] ?></h3>
               <p><?php echo $row['reason'] ?></p>
               <a href="deleterequests.php" class="btn btn-sm btn-primary"><i class="fas fa-arrow-circle-left"></i> Back to list</a>
              </div>
              <!-- /.card-body -->
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
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
</body>
</html>
