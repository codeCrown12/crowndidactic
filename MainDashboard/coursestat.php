<?php
session_start();
include_once ('../connection.php');
include_once ('../functions.php');

$selector = "";
$info = "";
$exp_warn = "";

if($_SESSION['email'] == ""){
  header("location: ../login");
}
else {
    $selector = $_SESSION['email'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Courses</title>
    
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
  <style>
      .btn-info{
    background-color: #2771d1;
    border: #2771d1;
}
.btn-info:hover{
    background-color: #285bca;
    border: #285bca;
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
            <h1 class="m-0">Courses</h1>
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Courses</h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body p-3">
              <?php
              $query = "SELECT ID, course, date FROM courses WHERE school_email = '$selector'";
              $result = $connection->query($query);
              if (!$result) {
                die($connection->error);
              }
              else{
                $rows = $result->num_rows;
                if ($rows < 1) {
                  echo "<p class='text-center' style='font-style: italic;'>No courses here yet</p>";
                }
                else{
                  echo "<table class='table table-responsive-sm table-striped table-bordered table-hover' style='width:100%' id='table_id'>
                  <thead>
                    <tr>
                      <th>NB</th>
                      <th>Course</th>
                      <th>Date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>";
                  for ($i=0; $i < $rows; $i++) {
                    $result->data_seek($i);
                    $data = $result->fetch_array(MYSQLI_ASSOC);
                    $j = $i + 1;
                    $short_course = "";
                    $id = $data['ID'];
                    
                    if(strlen($data['course']) > 30){
                        $short_course = substr($data['course'], 0, 30)."...";
                    }
                    else{
                      $short_course = $data['course'];
                    }
                    echo "<tr>
                    <td>$j</td>
                    <td>$short_course</td>
                    <td>$data[date]</td>
                    <td><a href='javascript:void(0)' data-id='$data[ID]' class='btn btn-sm btn-danger remove'>Remove <i class='fas fa fa-trash-alt'></i></a></td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
<script>
$(document).ready( function () {
    $('#table_id').DataTable();
    $('#table_id').on('click', '.remove', function(e){
    e.preventDefault()
    var parent = $(this).parent('td').parent('tr')
    var pid = $(this).attr('data-id');
    bootbox.dialog({
      size: "medium",
      title: "<i class='fas fa fa-trash-alt'></i> Remove!",
      message: "Do you really want to remove this course ?",
      buttons:{
        cancel_btn:{
          label: "Cancel",
          className: "btn-success",
          callback: function(){
            $('.bootbox').modal('hide')
          }
        },
        confirm_btn:{
          label: "Remove",
          className: "btn-danger",
          callback: function(){
            $.ajax({
              type: "POST",
              url: "removecourse.php",
              data: "delete="+pid
            })
            .done(function(response){
              bootbox.alert(response)
              parent.fadeOut('slow')
            })
            .fail(function(response){
               bootbox.alert("Something went wrong...")
            })
          }
        }
      }
    })
  })
} );
</script>
</body>
</html>
