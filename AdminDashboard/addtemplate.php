<?php
session_start();
include_once ('../connection.php');
include_once ('../functions.php');
$info = "";
if (isset($_POST['add'])){
    $title = check_string($connection,$_POST['title']);
    $fname = check_string($connection, $_POST['fname']);
    $theme = check_string($connection, $_POST['themable']);
    if($title == "" || $fname == "" || $_FILES['img']['name'] == ""){
        $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          Error all fields are required
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
    }
    else{
        $pic_name = $_FILES['img']['name'];
        $pic_type = $_FILES['img']['type'];
        switch ($pic_type) {
            case 'image/jpeg':
                $ext = 'jpg';
                break;
            case 'image/png':
                $ext = 'png';
                break;
            default:
                $ext = "";
                break;
            }
        if ($ext != "") {
                $newimg = "tempimages/".$fname.date('Y-m-d').rand().".png";
                move_uploaded_file($_FILES['img']['tmp_name'], $newimg);
                $query = "INSERT INTO templates (title, folder_name, image, themable) VALUES (?,?,?,?)";
                $result = $connection->prepare($query);
                $result->bind_param("ssss", $title, $fname, $newimg, $theme);
                if (!$result->execute()) {
                    $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          Error in connection
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
                }
                else{
                    $info = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          Template added successfully
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
                }
            }
        else{
            $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          File is not an image
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
  <title>Manage templates</title>

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
            <h1 class="m-0">Add a template</h1>
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
                if($info != ""){
                    echo $info;
                }
              ?>
            <div class="card card-primary">
                <div class="card-header">
                    <div class="card-title">Add a template</div>
  </div>
    <div class="card-body">
    <form action="addtemplate" method="POST" enctype="multipart/form-data">
    <div class="form-row">
    <div class="form-group col-md-12">
      <input type="text" name="title" class="form-control" placeholder="Title">
    </div>
    <div class="form-group col-md-12">
      <input type="text" name="fname" class="form-control" placeholder="Folder name">
    </div>
    <div class="form-group col-md-12">
         <select type="email" class="form-control" name="themable">
          <option value="yes">Yes</option>
          <option value="no">No</option>
          </select>
    </div>
    <div class="form-group col-md-12">
      <label>Preview image</label>
      <input type="file" name="img" class="form-control-file" placeholder="">
    </div>
     <div class="form-group col-md-12">
      <button class="btn btn-primary" type="submit" name="add">Submit <i class="fas fa-paper-plane"></i></button>
    </div>
  </div>
    </form>
    </div>
            <!-- /.card -->
          </div>
          <p class="text-center"><a href="#" style="text-decoration: underline;">View all templates</a></p>
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
