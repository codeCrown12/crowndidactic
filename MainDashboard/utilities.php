<?php
include_once ('../connection.php');
include_once ('../functions.php');
$info = '';
$selector = '';

session_start();
if($_SESSION['email'] == ""){
  header("location: ../login");
}
else{
  $selector = $_SESSION['email'];

  /********* Code to retrieve user details from database **********/
  $querydata = "SELECT caption_text, backgroundColor, TextColor FROM basicusers WHERE email = '$selector'";
  $resultSet = $connection->query($querydata);
  if(!$resultSet){
    die($connection->error);
  }
  else {
    $row = $resultSet->fetch_array(MYSQLI_ASSOC);
  }
  /********* End **********/

  /** section to update caption text */
  
  if (isset($_POST['add_cap'])) {
    $captiontxt = check_string($connection,  $_POST['caption_txt']);
    if($captiontxt == ""){
      $info = "All fields are required";
    }
    else if (strlen($captiontxt) > 100){
      $info = "Caption text should not be more than 15 words";
    }
    else{
      $query = " UPDATE basicusers SET caption_text = ? WHERE email = ?";
      $result = $connection->prepare($query);
      $result->bind_param("ss", $captiontxt, $selector);
      if(!$result->execute()){
        die($connection->error);
        $info = "Unable to update caption";
      }
      else{
        header("Refresh:0");
      }
    }
    
  }
  /** END of section to update caption text */
  else if (isset($_POST['upd_color'])){
    $bgcolor = $_POST['bgcolor'];
    $txtcolor = $_POST['txtcolor'];
    $query = "UPDATE basicusers SET backgroundColor = ?, TextColor = ? WHERE email = ?";
    $result = $connection->prepare($query);
    $result->bind_param("sss", $bgcolor, $txtcolor, $selector);
    if(!$result->execute()){
      die($connection->error);
      $info = "Unable to update color";
    }
    else {
      header("Refresh:0");
    }
  }
       
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crowndidactic | utilities</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/mystyle.css">
  <style>
  .box{
    border: 1px solid #ccc;
    border-radius: 12px;
    padding: 50px;
  }
  @media screen and (max-width: 700px){
    .box{
      padding: 10px;
    }
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
            <h1 class="m-0">Display</h1>
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
      <div class="container">
      <div class="row justify-content-center">
          <div class="col-sm-12 col-md-5">
          <?php if($info != '') echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Sorry!</strong> $info
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";  
  ?>
          <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Caption</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <div class="card-body">
                  <form action="utilities" method="POST">
                  <div class="form-group">
                  <p><strong>Note</strong>: caption text should not be more than 15 words</p>
                  <?php
                  
                  
                  ?>
                    <label for="">Caption</label>
                    <textarea name="caption_txt" class="form-control" placeholder="Enter caption (not more than 35 words)" name="about" rows="5"><?php echo $row['caption_text']; ?></textarea>
                  </div>
                  <button type="submit" name="add_cap" class="btn btn-primary mt-1">Update caption</button>
                  </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div class="col-sm-12 col-md-7">
          <div class="card card-primary">
            <div class="card-header">
            <h3 class="card-title">Theme</h3>
            </div>
            <div class="card-body">
            <p><strong>Note: </strong>Themes only apply to themeable templates</p>
            <form action="utilities" method="POST">
            <div class="form-row">
                  <div class="form-group col-md-4">
                  <label for="usertxtcolor">Change text color </label> <br>
                    <input type="color" class="form-control form-control-color" name="txtcolor" id="usertxtcolor" value="<?php echo $row['TextColor'] ?>">
                    <div class="form-group mt-1">
                  <label for="userbgcolor">Change background color </label> <br>
                    <input type="color"  class="form-control form-control-color" name="bgcolor" id="userbgcolor" value="<?php echo $row['backgroundColor'] ?>">
                  </div>
                  </div>
                  <div class="form-group col-md-8">
                    <div class="box text-center" style="background-color: <?php echo $row['backgroundColor']; ?>;color:<?php echo $row['TextColor']; ?>" id="preview">
                      <h5>This is a preview text showing you how your colors look like...</h5>
                    </div>
                  </div>
                </div>
                  <button class="btn btn-primary" type="submit" name="upd_color">Update color</button>
            </form>
            </div>
            </div>
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

<script>
const bgcolor = document.querySelector("#userbgcolor")
const txtcolor = document.querySelector("#usertxtcolor")
const prev =  document.querySelector("#preview")

bgcolor.addEventListener('input', (e)=>{
  prev.style.backgroundColor = e.target.value
})
txtcolor.addEventListener('input', (e)=>{
  prev.style.color = e.target.value
})


</script>
</body>
</html>
