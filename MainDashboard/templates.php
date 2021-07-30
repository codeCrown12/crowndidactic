<?php
session_start();
include_once ('../connection.php');
include_once ('../functions.php');

$selector = "";
$info = "";
$tempid = "";
$defrow = "";

if($_SESSION['email'] == ""){
  header("location: ../login");
}
else{
    $selector = $_SESSION['email'];
}

function getTempId($connection, $selector){
    $tempid = "";
    $query_one = "SELECT temp_id FROM basicusers WHERE email = '$selector'";
    $result_one = $connection->query($query_one);
    if(!$result_one){
        echo "Error in connection";
    }
    else{
        $data = $result_one->fetch_array(MYSQLI_ASSOC);
        $tempid = $data['temp_id'];
    }
    return $tempid;
}

if(isset($_POST['apply'])){
    $val = $_POST['apply'];
    $query = "UPDATE basicusers SET temp_id = ? WHERE email = ?";
    $result = $connection->prepare($query);
    $result->bind_param("ss", $val, $selector);
    if(!$result->execute()){
        $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    Error in connection!
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
    }
    else{
        header("Refresh:0");
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crowndidactic | Templates</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/mystyle.css">
  <style>
      .sub-txt{
    color: #8a8a8a;
    font-size: 15px;
}
.img-fit{
    object-fit: cover;
    width: 100%;
    height: 200px;
    border-radius: 5px;
    border: .5px #ccc solid;
}
.btn-info{
    background-color: #2771d1;
    border: #2771d1;
}
.btn-info:hover{
    background-color: #285bca;
    border: #285bca;
}
.sel-temp{
    margin-top: 134px
}
.large{
    font-size: 22px;
}
.sem-large{
    font-size: 19px;
}
.small{
    font-size: 13px;
}
@media screen and (max-width: 600px){
    .sel-temp{
    margin-top: 0px
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
            <h1 class="m-0">Templates</h1>
            <p class='sub-txt'>Choose the perfect theme for you</p>
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
        <div class="col-md-10 col-sm-12 mb-5">
            <div class="row">
                <?php
                    $tempid = getTempId($connection, $selector);
                    $query = "SELECT * FROM templates WHERE ID =".$tempid;
                    $res = $connection->query($query);
                    if(!$res){
                        die($connection->error);
                        echo "Error in connection";
                    }
                    else{
                        $row = $res->fetch_array(MYSQLI_ASSOC);
                        echo $row['fname'];
                    }
                ?>
                    <div class="col-sm-4 mt-3">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1" checked>
                    <img src="../AdminDashboard/<?php echo $row['image'] ?>" class="img-fit" alt="">
                    </div>
                    <div class="col-sm-4">
                    <p class="sel-temp large"><?php echo $row['title'] ?><span><small class="small">
                        <?php
                        if($row['themable'] == 'yes'){
                            echo "(Themeable)";
                        }
                        else{
                            echo "(Not themeable)";
                        }
                        ?>
                    </small></small></span></p>
                    <button class="btn btn-success btn-sm" disabled>Applied</button>
                    </div>
                </div>
            <form action="" method="post">
            <div class="row">
                <?php
                $query = "SELECT * FROM templates";
                $result = $connection->query($query);
                if(!$result){
                    echo "No templates available at the moment";
                }
                else{
                    $nums = $result->num_rows;
                    if($nums < 1){
                        echo "No templates available at the moment";
                    }
                    else{
                    for($i= 0; $i<$nums; $i++){
                        $result->data_seek($i);
                        $row = $result->fetch_array(MYSQLI_ASSOC);
                ?>
                <div class="col-sm-4 mt-5">
                    <p class="sem-large"><?php echo $row['title'] ?><br> <span><small class="small">
                        <?php
                        if($row['themable'] == 'yes'){
                            echo "(Themeable)";
                        }
                        else{
                            echo "(Not themeable)";
                        }
                        ?>
                    </small></small></span></p>
                    <img src="../AdminDashboard/<?php echo $row['image'] ?>" class="img-fit" alt="">
                    <div class="mt-3" style="width: 60%;margin-left: auto;margin-right: auto;">
                        <a class="btn btn-info btn-block" href="../<?php echo $row['folder_name']?>/index?selector=<?php echo $_SESSION['email']?>" target="_blank">preview <i class="far fa-eye"></i></a>
                    <button class="btn btn-info btn-block" name="apply" value="<?php echo $row['ID'] ?>" type="submit">Apply</button>
                    </div>
                </div>
                <?php
                        }
                    }
                } 
                ?>
            </div>
            </form>
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