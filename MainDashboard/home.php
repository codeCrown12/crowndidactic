<?php
session_start();
include_once ('../connection.php');
include_once ('../functions.php');
//Variable for selecting user specific data

$selector = ""; 
$errmsg = "";
$date = date("Y-m-d");
$test = "";

//function to replace quotes
function replace_quotes($string){
    $string =  str_replace("'", "~", $string);
    $string = str_replace('"', "~", $string);
    return $string;
}


if($_SESSION['email'] == ""){
  header("location: ../login");
}
else{

    /********* Code to retrieve user details from database **********/
    $selector = $_SESSION['email'];
    $query = "SELECT Name, category, address, about, mobile, profileimg FROM basicusers WHERE email = '$selector' ";
    $user_result = $connection->query($query);
    if (!$user_result) {
        die($connection->error);
    }
    $user_record = $user_result->fetch_array(MYSQLI_ASSOC);
    /* End of data retrieval code */


    /********* Code to update details in the database **********/
    if (isset($_POST['update'])) {
        $name = check_string($connection, $_POST['schname']);
        $address = check_string($connection, $_POST['address']);
        $cat = $_POST['category'];
        $abt = check_string($connection, $_POST['about']);
        $mobile = check_string($connection, $_POST['mobile']);
        if ($name == "" || $address == "" || $abt == "" || $mobile == "") {
            $errmsg = "Some fields are empty";
        } else {
            $name = replace_quotes($name);
            $address = replace_quotes($address);
            $abt = replace_quotes($abt);
            $mobile = replace_quotes($mobile);
            $upd_query = "UPDATE basicusers SET Name = ?, category = ?, address = ?, about = ?, mobile = ? WHERE email = ?";
            $upd_result = $connection->prepare($upd_query);
            $upd_result->bind_param("ssssss", $name, $cat, $address, $abt, $mobile, $selector);
            if (!$upd_result->execute()) {
                die($connection->connect_error);
                $errmsg = "Error in connection";
            } else {
                header("Refresh:0");
            }
        }
    }
     /* End of code to check details */

    //snippet for updating profile image/school logo
    if ($_FILES) {
        $name = $_FILES['profilepic']['name'];
        $user_id = $selector;
        switch ($_FILES['profilepic']['type']) {
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
            
            $newimg = "uploads/".$user_id.".png";
            move_uploaded_file($_FILES['profilepic']['tmp_name'], $newimg);

            if ($ext == 'jpg') {
                $src = imagecreatefromjpeg($newimg);
            } elseif ($ext == 'png') {
                $src = imagecreatefrompng($newimg);
            }
            list($w, $h) = getimagesize($newimg);
            $max = 100;
            $tw = $max;
            $th = $max;
            $tmp = imagecreatetruecolor($tw, $th);
            imagecopyresized($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
            imagepng($tmp, $newimg);
            imagedestroy($tmp);
            imagedestroy($src);
    
            $query = "UPDATE basicusers SET profileimg = ? WHERE email = ?";
            $result = $connection->prepare($query);
            $result->bind_param("ss", $newimg, $selector);
            if (!$result->execute()) {
                $errmsg = "Error in connection";
            } else {
                header("Refresh:0");
            }
        }
        else {
          $errmsg =  "No file was selected or invalid file format";
        }
    }
    //End of image upload snippet

    //Section to update and add custom category

    if (isset($_POST['add_cat'])) {
      $newcat = ucwords($_POST['new_cat']);
      if ($newcat == "") {
          $errmsg = "Field is empty";
      }
      else{
        $newcat = check_string($connection, $newcat);
        $query = "INSERT INTO categories (category) VALUES ('$newcat')";
        $result = $connection->query($query);
        if(!$result){
            die($connection->error);
            $errmsg = "Unable to add category";
        }
        else{
          $upd = update_school_cat($newcat, $selector); 
          if($upd == false){
            $errmsg = "Unable to add category";
          }
          else{
            header("Refresh:0");
          }
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
  <title>Crowndidactic | Home</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- summernot style -->
  <!--<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">-->
  <link rel="stylesheet" href="dist/css/mystyle.css">
  <style>
  .hide_border{
    border: 0px;
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
            <h1 class="m-0">Profile</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <?php 
            if($errmsg != '') {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Sorry!</strong> $errmsg
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
            }
  ?>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?php echo $user_record['profileimg'];?>?randomurl=<?php echo rand();?>"
                       alt="User profile picture">
                </div>
                <a type="button" class="btn btn-primary btn-block mt-3" data-toggle="modal" data-target="#modal-addphoto"><b>Edit logo <i class="fas fa-camera mr-2"></i></b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- About information -->
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title">About info</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr> -->

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted"><?php
                if (strlen($user_record['address']) > 60){
                  echo substr($user_record['address'], 0, 60)."...";
                }
                else  echo $user_record['address'];
                ?></p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Category</strong>

                <p class="text-muted">
                  <?php  echo $user_record['category']; ?>
                </p>
               <hr>

                <strong><i class="far fa-file-alt mr-1"></i> About text</strong>

                <p class="text-muted"><?php  if (strlen($user_record['about']) > 60){
                  echo substr($user_record['about'], 0, 60)."...";
                }
                else  echo $user_record['about'];?></p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
          <div class="col-md-9">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Edit Profile</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="home" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Tutor/institution name</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="schname" value="<?php echo $user_record['Name'];?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Address</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="address" value="<?php echo $user_record['address'];?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Mobile</label>
                    <input type="text" class="form-control" id="exampleInputPassword1" name="mobile" value="<?php echo $user_record['mobile'];?>">
                  </div>
                  <div class="form-group">
                    <label for="">Category</label>
                    <select class="form-control" name="category" id="">
                    <option value="<?php echo $user_record['category']; ?>"><?php echo $user_record['category']; ?></option>
                      <?php
                      // *********** Database query to select categories ************
                               $querycat = "SELECT category FROM categories";
                               $result = $connection->query($querycat);
                               if(!$result) die ($connection->error);
                               $rows = $result->num_rows;

                                for($i=0; $i<$rows; $i++){
                                    $result->data_seek($i);
                                    $row = $result->fetch_array(MYSQLI_ASSOC);
                                    if($row['category'] != $user_record['category']){
                                      echo "<option value='".$row['category']."'>".$row['category']."</option>";
                                    }
                                }
                                $result->close();
                                ?>
                    </select>
                  </div>
                  <?php
                  if ($user_record['category'] == "others") {
                    echo "<div class='form-group'>
                    <button data-toggle='modal' type='button' data-target='#modal-cat' class='btn btn-default'>Add category</button>
                    </div>"; 
                  }
                  
                  ?>
                  <div class='form-group'>
                      <label for="">Portfolio link</label>
                      <div class="input-group">
                  <input type="text" class="form-control" id='sitelink' readonly value='https://crowndidactic.com/<?php echo get_fname($connection, $user_record['temp_id']) ?>/index?selector=<?php  echo $selector ?>'>
                  <div class="input-group-append">
                    <button type='button' class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="click to copy" id='copybtn'><i class="fas fa-copy"></i></button>
                  </div>
                </div>
                  </div>
                
                  <div class="form-group">
                    <label for="">About text</label> <small>(Max 3600 characters)</small>
                    <textarea class="form-control test" name="about" rows="5"><?php echo $user_record['about'];?></textarea>
                  </div>
                </div>

                <!--<input type="hidden" readonly name="abt_html" id="sum_html">-->
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="update" onclick="window.location.reload(true)"  class="btn btn-primary">Save changes</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        <div class="modal fade" id="modal-addphoto">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Select photo to upload</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="home" enctype="multipart/form-data" method="POST">
            <div class="modal-body">
            <div class="form-group">
                <label for="exampleFormControlFile1">select image</label>
                <input type="file" name="profilepic" class="form-control-file" id="exampleFormControlFile1">
            </div>
              <!-- <button type="submit" class="btn btn-primary">Upload photo</button> -->
            </div>
            <div class="modal-footer justify-content-end">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Upload photo</button>
            </div>
            </form>
          </div>
        <!-- /.modal-dialog -->
      </div>
      </div>
      <div class="modal fade" id="modal-cat">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header hide_border">
              <h4 class="modal-title"> <i class="fas fa-cat"></i> Custom category</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="home" method="POST">
            <div class="modal-body">
              <div class="form-group">
                <input type="text" class="form-control" id="newcat" name="new_cat" placeholder="Enter category">
              </div>
            </div>
            <div class="modal-footer justify-content-end  hide_border">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" name="add_cat" class="btn btn-primary ml-auto">Add category</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.container-fluid -->
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
  
  </div>
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
<script>
    $(document).ready(function(){
        
  $('#copybtn').tooltip();
  
  $('#copybtn').bind('click', function(){
      $('#sitelink').select();
      var success = document.execCommand("copy");
    if(success){
        $('#copybtn').trigger('copied', ['Copied!']);
    }
    else{
        $('#copybtn').trigger('copied', ['Copy with Ctrl-c']);
    }
    
  });
  
  $('#copybtn').bind('copied', function(event, message) {
  $(this).attr('data-original-title', message)
      .tooltip('update')
      .tooltip('show')
      .attr('data-original-title', "Copy to Clipboard")
      .tooltip('update')
});
  
});
</script>
</body>
</html>