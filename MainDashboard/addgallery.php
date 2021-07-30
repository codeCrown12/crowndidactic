<?php
session_start();
include_once ('../connection.php');
include_once ('../functions.php');

$selector = "";

if($_SESSION['email'] == ""){
  header("location: ../login");
}
else{
    $selector = $_SESSION['email'];

    $info = '';
    if (isset($_POST['add'])) {
        $name = $_FILES['gal_image']['name'];
        $user_id = $selector;
        $caption = check_string($connection, $_POST['caption']);
        if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $caption)){
          $errmsg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
          <strong>Error!</strong> Some illegal characters were found
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
    }
    else{
        switch ($_FILES['gal_image']['type']) {
        case 'image/jpeg':
            $ext = 'jpg';
            break;
        case 'image/png':
            $ext = 'png';
            break;
        default:
            $ext = '';
            break;
        }

        if ($ext != '') {
            $newimg = "gallery/".$user_id.date('Y-m-d').rand().".png";
            move_uploaded_file($_FILES['gal_image']['tmp_name'], $newimg);
            $query = "INSERT INTO gallery (school_email, image, caption) VALUES (?, ?, ?)";
            $result = $connection->prepare($query);
            $result->bind_param("sss", $selector, $newimg, $caption);
            if (!$result->execute()) {
                $info = "Error in connection";
            } else {
                header("Refresh:0");
            }
        } else {
            $info =  "No file was selected or invalid file format";
        }
    }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Crowndidactic | Gallery</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/mystyle.css">
  <style>
.mycard_box{
          overflow: auto;
          height: 300px;
          width: 100%;
}
.img-cover{
    position: relative;
}
.img-cover:hover .overlay {
    opacity: 1;
    cursor: pointer;
  }
.overlay {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    height: 100%;
    width: 100%;
    opacity: 0;
    transition: .5s ease;
    border-radius: 7px;
    background: rgba(0, 0, 0, 0.5) !important;
}
.text {
    color: white;
    font-size: 20px;
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    text-align: center;
}
      .up_img{
              width: 100%;
              object-fit: cover;
          }
        .red{
          color: red;
          font-size: larger;
        }
        .close-btn{
          width: fit-content;
          background-color: transparent;
          margin-bottom: 2px;
          /* border: solid black 1px; */
          display: block;
          margin-left: auto;
        }
      @media screen and (max-width: 600px){
          .up_img{
              width: 100%;
          }
          .mycard_box{
          overflow: auto;
          height: 500px;
          width: 100%;
      }
      }
      @media screen and (min-width: 700px) and (max-width: 1200px){
        .up_img{
          width: 100%;
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
            <h1 class="m-0">Gallery</h1>
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
        <div class="col-md-11 col-sm-12">
        <?php if($info != '') echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Sorry!</strong> $info
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";  
  ?>
        <div class="card card-primary">
              <div class="card-header">
                <h4 class="card-title">My images</h4>
              </div>
              <div class="card-body mycard_box">
                <div class="row">
                  <?php
                  $sel_query = "SELECT ID, image FROM gallery WHERE school_email = '$selector'";
                  $img_res = $connection->query($sel_query);
                  if(!$img_res){
                    die($connection->error);
                  }
                  else{    
                    $rows = $img_res->num_rows;
                    if($rows < 1){
                      echo "<div class='col-sm-12'>
                      <p class='text-center' style='font-style: italic;'>No images here yet. click the button below to add images</p>
                      <p class='text-center' style='font-size: 40px;'><i class='far fa-folder-open'></i></p>
                      </div>";
                    }
                    else{
                      for($i=0; $i<$rows; $i++){
                        $img_res->data_seek($i);
                        $row = $img_res->fetch_array(MYSQLI_ASSOC);
                        $imageurl = $row['image'];
                        echo "<div class='col-sm-3 mt-2'>
                        <div class='card p-1'>                      
                        <a data-id='$row[ID]' data-img='$row[image]' class='close-btn' href='javascript:void(0)'><i class='fas fa-times-circle red'></i></a>
                        <div class='img-cover'>
                        <img src='$row[image]' class='up_img' alt='' height='250'>
                        <div class='overlay'>
                         <div class='text'><a class='btn btn-sm btn-outline-light' href='imgcaption?id=$row[ID]'><i class='fas fa-pen'></i> Edit caption</a></div>
                         </div>
                         </div>
                        </div>
                        </div>
                        ";
                        ;
                      }
                    }
                  }
                ?>
                </div>
              </div>
              <div class="card-footer">
                  <button  type="button"  class="btn btn-primary" data-toggle="modal" data-target="#modal-default-photo">Add photo</button>
              </div>
            </div>
        </div>
        </div>

        <div class="modal fade" id="modal-default-photo">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Select photo to upload</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="galtest" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
            <div class="form-group">
                <label>select image</label>
                <input type="file" name="gal_image" class="form-control-file">
            </div>
            <div class="form-group">
                <label>Caption <small>(Optional)</small></label>
                <input type="text" placeholder="Add a nice caption for your image" name="caption" class="form-control">
            </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="add">Upload photo</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
<script>
  $(document).ready(function(){
    $('.close-btn').click(function(e){
      e.preventDefault();
      var pid = $(this).attr('data-id');
      var img = $(this).attr('data-img');
      var parent = $(this).parent(".card").parent(".col-sm-3");
      bootbox.dialog({
        size: "medium",
        message : "Do you really want to delete this photo ?",
        title : "<i class='fas fa fa-trash-alt'></i> Delete!",
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
            label: "Delete!",
            className: "btn-danger",
            callback:function(){
              $.ajax({
                type: 'POST',
                url: 'deleteimage.php',
                data: {delete: pid, image: img}
              })
              .done(function(){
                parent.fadeOut('slow')
              })
              .fail(function(){
                bootbox.alert("something went wrong...")
              })
            }
          }
        }
      })
    })
  })
</script>
</body>
</html>