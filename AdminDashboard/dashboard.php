<?php
session_start();
include_once ('../connection.php');
include_once ('../functions.php');
$ad_selector = "";


if($_SESSION['ad_uname'] == ""){
    header("location: login");
}



/** functions to select and count general data*/

// all accounts
function count_all_schools($connection){
  $query = "SELECT COUNT(*) AS total FROM basicusers";
  $result = $connection->query($query);
  if (!$result) {
    die($connection->error);
  }
  else{
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row['total'];
  }
}

// active accounts
function count_all_active_schools($connection){
  $query = "SELECT COUNT(*) AS total FROM basicusers WHERE Status = 'Active'";
  $result = $connection->query($query);
  if (!$result) {
    die($connection->error);
  }
  else{
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row['total'];
  }
}

// inactive accounts
function count_all_inactive_schools($connection){
  $query = "SELECT COUNT(*) AS total FROM basicusers WHERE Status = 'Inactive'";
  $result = $connection->query($query);
  if (!$result) {
    die($connection->error);
  }
  else{
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row['total'];
  }
}

// Feedbacks
function count_feedbacks($connection){
  $query = "SELECT COUNT(*) AS total FROM feedbacks WHERE Status = 'Unread'";
  $result = $connection->query($query);
  if (!$result) {
    die($connection->error);
  }
  else{
    $row = $result->fetch_array(MYSQLI_ASSOC);
    return $row['total'];
  }
}

/** End of functions to select and count general data*/
?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

 <!-- Datatables plugin -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
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
            <h1 class="m-0">Overview</h1>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo count_all_schools($connection); ?></h3>

                <p>Registered users</p>
              </div>
              <!-- <div class="icon">
                <i class="ion ion-bag"></i>
              </div> -->
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo count_all_active_schools($connection);?></h3>

                <p>Active users</p>
              </div>
              <!-- <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div> -->
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo count_all_inactive_schools($connection); ?></h3>
                <p>Inactive users</p>
              </div>
              <!-- <div class="icon">
                <i class="ion ion-person-add"></i>
              </div> -->
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo count_feedbacks($connection); ?></h3>
                <p>Feedbacks</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="row">
        <div class="col-md-12">
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Message Schools</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-3">
              <?php
              $query = "SELECT * FROM basicusers";
              $result = $connection->query($query);
              if (!$result) {
                die($connection->error);
              }
              else{
                $rows = $result->num_rows;
                if ($rows < 1) {
                  echo "<p class='text-center' style='font-style: italic;'>No users yet</p>";
                }
                else{
                  echo "<table class='table table-responsive-sm table-striped table-bordered table-hover' style='width:100%' id='table_id'>
                  <thead>
                    <tr>
                      <th>NB</th>
                      <th>School Name</th>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Registration date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>";
                  for ($i=0; $i < $rows; $i++) {
                    $result->data_seek($i);
                    $data = $result->fetch_array(MYSQLI_ASSOC);
                    $name = replace_curl($data['Name']);
                    $j = $i + 1;
                    $color = "info";
                    if ($data['Status'] != "Active") {
                      $color = "danger";
                    }
                    echo "<tr>
                    <td>$j</td>
                    <td>$name</td>
                    <td>$data[email]</td>
                    <td><span class='right badge badge-$color'>$data[Status]</span></td>
                    <td>$data[app_date]</td>
                    <td><span><a type='submit' href='composeMails.php?sch_id=$data[email]' class='btn btn-sm btn-success'>Message <i class='fas fa-paper-plane'></i></a></span></td>
                  </tr>";
                  }
                  echo "</tbody>
                  </table>";
                }
              }
              ?> 
              </div>
              <div class="card-footer">
                <a class="btn btn-outline-info" href="composeMails.php?status=active">Message active <i class='fas fa-paper-plane'></i></a>
                <a class="btn btn-outline-danger" href="composeMails.php?status=inactive">Message inactive <i class='fas fa-paper-plane'></i></a>
                <a class="btn btn-outline-success" href="composeMails.php">Message all <i class='fas fa-paper-plane'></i></a>
              </div>
              <!-- /.card-body -->
            </div>
        </div>
        </div>
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
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
    </div>
    <!-- Default to the left -->
    <p>Copyright &copy; 2014-2020 CrownEducation &nbsp; <small>All rights reserved.</small></p>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready( function () {
    $('#table_id').DataTable();
} );
</script>
</body>
</html>
