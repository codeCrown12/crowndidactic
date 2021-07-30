<?php
session_start();
include_once ('../connection.php');
include_once ('../functions.php');

$selector = "";
$row = "";
$info = "";
$email = "";

if($_SESSION['email'] == ""){
  header("location: ../login");
}
else {
  $selector = $_SESSION['email'];
  if (isset($_GET['app_id'])) {
    $email = $_GET['app_id'];
    $query = "SELECT * FROM applicants WHERE school_email = '$selector' AND email = '$email'";
    $result = $connection->query($query);
    if (!$result) {
      die($connection->error);
      $info = "<p style='color: red;' class='text-center'>Error in connection</p>";
    }
    else{
      $row = $result->fetch_array(MYSQLI_ASSOC);
    }
  }

  
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crowndidactic | Applicants</title>

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
            <h1 class="m-0">Student Details</h1>
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
          <div class="col-md-10">
          <?php
          if ($info != "") {
            echo $info;
          }
          ?>
            <div class="card">
                <div class="card-body">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">First Name</label>
      <input type="text" class="form-control" id="inputEmail4" readonly value="<?php echo $row['firstname'] ?>">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Last Name</label>
      <input type="text" class="form-control" id="inputPassword4" readonly value="<?php echo $row['lastname'] ?>">
    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-6">
    <label for="inputAddress">Email</label>
    <input type="email" class="form-control" id="inputAddress" placeholder="youremail@server.com" readonly value="<?php echo $row['email'] ?>">
  </div>
  <div class="form-group col-md-6">
      <label for="inputPassword4">Date of birth</label>
      <input type="date" class="form-control" id="inputPassword4" readonly value="<?php echo $row['dob'] ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Address</label>
    <input type="text" class="form-control" id="inputAddress" readonly value="<?php echo $row['address'] ?>">
  </div>
  <div class="form-group">
    <label for="inputAddress">Course</label>
    <input type="text" class="form-control" id="inputAddress" readonly value="<?php echo $row['course'] ?>">
  </div>
  <div class="form-row">
  <div class="form-group col-md-6">
      <label for="inputEmail4">Mobile</label>
      <input type="text" class="form-control" id="inputEmail4" readonly value="<?php echo $row['mobile'] ?>">
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Application date</label>
      <input type="date" class="form-control" id="inputPassword4" readonly value="<?php echo $row['app_date'] ?>">
    </div>
  </div>
  <a href="composeMails?app_id=<?php echo $row['email'] ?>" class="btn btn-success"><i class="fas fa-edit"></i> Message student</a>
  <button class="btn btn-danger clear" name="remove" data-id = "<?php echo $row['email'] ?>"><i class="fas fa-trash-alt"></i> Remove</button>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
<script>
$('.clear').click(function(e){
      e.preventDefault();
      var pid = $(this).attr('data-id');
      bootbox.dialog({
        size: "medium",
        message : "Do you really want to remove this student ?",
        title : "<i class='fas fa fa-trash-alt'></i> Remove student!",
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
            label: "Remove!",
            className: "btn-danger",
            callback:function(){
              $.ajax({
                type: 'POST',
                url: 'clearlist.php',
                data: 'appmail='+pid
              })
              .done(function(response){
                location.href = 'applicants'
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
