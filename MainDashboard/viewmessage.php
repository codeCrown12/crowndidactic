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


if (isset($_GET['msg_id'])) {
    $id = $_GET['msg_id'];
    $query = "SELECT title, message, date FROM feedbacks WHERE ID = $id";
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
  <title>View message</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- summernot style -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
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
          ?>
          <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">Message body</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <small><?php echo $row['date'] ?></small>
              <h4 class="mt-3"><?php echo $row['title'] ?></h4>
               <p><?php echo $row['message'] ?></p>
              <a class="btn btn-sm btn-primary" href="feedbackstat">Back to list</a>
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
<!-- Summernote -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(document).ready(function () {
   
    //Add text editor
    //  $('#compose-textarea').summernote()
  $('#compose-textarea').summernote({
  toolbar: [
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['insert', ['link']],
  ],
  height: 300,
  // callbacks:{
  //   onImageUpload: function(files){
  //     for(var i = files.length - 1; i>=0; i--){
  //       sendfile(files[i]);
  //     }
  //   }
  // }
});
// function sendfile(file){
//   data = new FormData();
//     data.append("file", file);
//     $.ajax({
//       data: data,
//       type: "POST",
//       url: "test.php",
//       cache: false,
//       contentType: false,
//       processData: false,
//       success: function(url) {
//         var image = $('<img>').attr('src', 'http://' + url);
//             $('#').summernote("insertNode", image[0]);
//       }
//     });
// }
}); 
</script>
</body>
</html>
