<?php
session_start();
include_once ('../connection.php');
include_once ('../functions.php');

$selector = "";
$info = "";
$id = "";
$row = "";

if($_SESSION['email'] == ""){
  header("location: ../login");
}
else{
    $selector = $_SESSION['email'];
    
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $query = "SELECT caption FROM gallery WHERE ID = $id";
        $res = $connection->query($query);
        if(!$res){
            die($connection->error);
        }
        else{
            $row = $res->fetch_array(MYSQLI_ASSOC);
        }
    }
    
    if (isset($_POST['edit'])) {
        $cap = check_string($connection, $_POST['caption']);
          $query = "UPDATE gallery SET caption = ? WHERE ID = ?";
          $res = $connection->prepare($query);
          $res->bind_param("ss", $cap, $id);
          if (!$res->execute()) {
            die($connection->error);
            $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          Unable to edit caption
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
          }
          else {
              header( "refresh:2; url=imgcaption?id=$id" );
            $info = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          Caption edited successfully
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
  <title>Crowndidactic | courses</title>

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
            <h1 class="m-0">Edit image caption</h1>
          </div><!-- /.col -->
          <!-- <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"> Page</li>
            </ol>
          </div>/.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-9 col-sm-12">
        <?php
        if ($info != "") {
            echo $info;
        }
        
        ?>
        <div class="card card-primary">
              <div class="card-header">
                <h4 class="card-title">Edit image caption</h4>
              </div>
              <div class="card-body mycard_box">
            <p><strong>Note: </strong>Changes made will be shown in your portfolio</p>
            <form action="imgcaption?id=<?php echo $id ?>" method="POST">
            <div class="form-group">
              <input class="form-control" type="text" name="caption" value="<?php echo $row['caption']; ?>">
            </div>
                <div class="form-group">
                <button type="submit" name="edit" class="btn btn-primary ml-auto"><i class="fas fa-pen"></i> Save</button>
                </div>
            </form>
              </div>
            </div>
        </div>
        </div>
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
<!-- <script src="plugins/toastr/toastr.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
  $(function(){
    $('.toastrDefaultSuccess').click(function() {
      toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
  });
</script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
</body>
</html>