<?php
session_start();
include_once ('../connection.php');
include_once ('../functions.php');

$selector = "";
$info = "";

if($_SESSION['email'] == ""){
  header("location: ../login");
}
else{
  $selector = $_SESSION['email'];
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crowndidactic | Students</title>
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
            <h1 class="m-0">Students</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="row justify-content-center">
          <div class="col-12">
          <div class="card p-1">
              <div class='card-header'><h3 class="card-title">All students</h3></div>
          <div class="card-body">
                    <?php
                    $query = "SELECT * FROM applicants WHERE school_email = '$selector'";
                    $result = $connection->query($query);
                    $rows = 0;
                    if (!$result) {
                      die($connection->error);
                      $info = "Error in connection";
                    }
                    else {
                      $rows = $result->num_rows;
                      if ($rows > 0) {
                        echo "<table id='table_id'  class='table table-responsive-sm table-striped table-bordered table-hover' style='width:100%'>
                      <thead>
                        <tr>
                          <th>NB</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>Email</th>
                          <th>Mobile</th>
                          <th>Application Date</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>";

                      for ($i=0; $i < $rows; $i++) {
                        $j = $i + 1; 
                        $result->data_seek($i);
                        $row = $result->fetch_array(MYSQLI_ASSOC);
                        
                        $fname_len = strlen($row['firstname']);
                        $lname_len = strlen($row['lastname']);
                        $email_len = strlen($row['email']);
                        $shortemail = '';

                        if ($fname_len > 20) {
                          $row['firstname'] = substr($row['firstname'], 0, 20)."...";
                          
                        }
                        
                        if($lname_len > 20){
                          $row['lastname'] = substr($row['lastname'], 0, 20)."...";
                        }
                        
                        if($email_len > 20){
                          $shortemail = substr($row['email'], 0, 20)."...";
                        }
                        else{
                            $shortemail = $row['email'];
                        }
                        
                        echo "<tr>
                        <td>$j</td>
                        <td>$row[firstname]</td>
                        <td>$row[lastname]</td>
                        <td>$shortemail</td>
                        <td>$row[mobile]</td>
                        <td>$row[app_date]</td>
                        <td><span><a href='applicantDetails?app_id=$row[email]' class='btn btn-sm btn-info'>View more &rsaquo;&rsaquo;</a></span></td>
                      </tr>";
                      }
                      echo "</tbody>
                      </table>";

                      }
                      else {
                        echo "<p style='font-style: italic;font-size: 17px;' class='text-center'>No students available yet</p>";
                      }
                    }
                    ?>
          </div>
          </div>
                <?php
                if ($rows > 0) {
                  echo " 
                  <div class='justify-content-sm-center mt-2 text-center mb-5'>
                  <a href='composeMails' class='btn btn-success'><i class='fas fa-mail-bulk'></i> Message all students</a>
                  <button name='clear' class='btn btn-danger clear'><i class='fas fa-trash-alt'></i> Clear list</button>
                  </div>
                  ";
                }
                ?>
          </div>
        </div>
        <!-- /.row -->
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
} );

$('.clear').click(function(e){
      e.preventDefault();
      var clear = "yes";
      bootbox.dialog({
        size: "medium",
        message : "Do you really want to clear list?",
        title : "<i class='fas fa fa-trash-alt'></i> Clear list!",
        buttons: {
          cancel_btn:{
            label: "Cancel",
            className: 'btn-success',
            callback: function(){
              //code to close the dialog box
              $('.bootbox').modal('hide');
            }
          },
          confirm_btn:{
            label: "Clear!",
            className: "btn-danger",
            callback:function(){
              $.ajax({
                type: 'POST',
                url: 'clearlist.php',
                data: 'clear='+clear
              })
              .done(function(response){
                location.reload()
              })
              .fail(function(response){
                bootbox.alert(response)
              })
            }
          }
        }
      })
    })
</script>
</body>
</html>
