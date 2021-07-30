<?php
session_start();
include_once ('../connection.php');
include_once ('../functions.php');

if($_SESSION['ad_uname'] == ""){
    header("location: login");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Delete requests</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Datatables plugin -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
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
            <h1 class="m-0">Delete requests</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="row justify-content-center">
          <div class="col-md-11 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Delete requests</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-3">
              <?php
              $query = "SELECT delete_reasons.ID, delete_reasons.title, delete_reasons.reason, delete_reasons.date, basicusers.Name, basicusers.email FROM delete_reasons
              INNER JOIN basicusers ON basicusers.email=delete_reasons.school_email";
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
                      <th>Date</th>
                      <th>Title</th>
                      <th>Reason</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>";
                  for ($i=0; $i < $rows; $i++) {
                    $result->data_seek($i);
                    $data = $result->fetch_array(MYSQLI_ASSOC);
                    $j = $i + 1;
                    $short_msg = "";
                    $short_title = "";
                    $short_name = "";
                    $short_email = "";
                    $title = $data['title'];
                    $date = $data['date'];
                    $message = $data['reason'];
                    $sch_name = $data['Name'];
                    $email = $data['email'];
                    $id = $data['ID'];
                    if(strlen($message) > 20){
                        $short_msg = substr($message, 0, 20)."...";
                    }
                    else{
                      $short_msg = $message;
                    }

                    if (strlen($title) > 20) {
                      $short_title = substr($title, 0, 20)."...";
                    }
                    else{
                      $short_title = $title;
                    }

                    if (strlen($sch_name) > 20) {
                      $short_name = substr($sch_name, 0, 20)."...";
                    }
                    else{
                      $short_name = $sch_name;
                    }

                    if (strlen($email) > 20) {
                      $short_email = substr($email, 0, 20)."...";
                    }
                    else{
                      $short_email = $email;
                    }
                    echo "<tr>
                    <td>$j</td>
                    <td>$sch_name</td>
                    <td>$email</td>
                    <td>$date</td>
                    <td>$short_title</td>
                    <td>$short_msg</td>
                    <td><a type='submit' href='viewdelete.php?msg_id=$id' class='btn btn-sm btn-info'>View message</a></td>
                  </tr>";
                  }
                  echo "</tbody>
                  </table>";
                }
              }
              ?> 
              </div>
              <!-- /.card-body -->
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
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready( function () {
    $('#table_id').DataTable();
});
</script>
</body>
</html>
