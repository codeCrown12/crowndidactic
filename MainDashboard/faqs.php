<?php
include_once ('../connection.php');
include_once ('../functions.php');
session_start();
$selector = '';
if($_SESSION['email'] == ""){
  header("location: ../login");
}
else {
  $selector = $_SESSION['email'];
}


//code to insert new question and answer
$msg = "";
if (isset($_POST['add_list'])) {
  $question = check_string($connection, $_POST['question']);
  $answer = check_string($connection, $_POST['answer']);

  if ($question == "" || $answer == "") {
    $msg = "All fields are required";
  }
  else{
    $query = "INSERT INTO faqs_table (school_email, question, answer) VALUES (?, ?, ?)";
  $res = $connection->prepare($query);
  $res->bind_param("sss", $selector, $question, $answer);
  if(!$res->execute()){
    die($connection->error);
    $msg = "Error in insertion";
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
  <title>Crowndidactic | Faqs settings</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/mystyle.css">
  <style>
    .del_btn{
      color: black;
    }
    .del_btn:hover{
      color: red;
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
            <h1 class="m-0">FAQs Settings</h1>
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
          <div class="col-md-10">
            <?php if($msg != '') echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Sorry!</strong> $msg
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";  
  ?>
          </div>
        </div>
      <div class="row justify-content-center">
          <div class="col-sm-12 col-md-10">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">My Questions and answers</h3>

                <!-- <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div> -->
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 270px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>Question</th>
                      <th>Answer</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    //code to display questions and answers
                    $querySelect = "SELECT ID, question, answer FROM faqs_table WHERE school_email = '$selector'";
                    $res_select = $connection->query($querySelect);
                    if (!$res_select) {
                      die($connection->error);
                      $msg = "Unable to display questions temporarily";
                    }
                    else {
                      $rows = $res_select->num_rows;
                      for ($i=0; $i < $rows; $i++) { 
                        $res_select->data_seek($i);
                        $row = $res_select->fetch_array(MYSQLI_ASSOC);
                        $row_num = $i + 1;
                        if (strlen($row['answer']) > 50 || strlen($row['question']) > 50) {
                          $short = substr($row['answer'], 0, 50);
                          $newshort = substr($row['question'], 0, 50);
                          echo "<tr>
                        <td>$newshort...</td>
                        <td>$short...</td>
                        <td><a href='javascript:void(0)' data-id='$row[ID]' class='del_btn'><i class='fas fa fa-trash-alt'></i></a></td>
                      </tr>";
                        }
                        else {
                        echo "<tr>
                        <td>$row[question]</td>
                        <td>$row[answer]</td>
                        <td><a href='javascript:void(0)' data-id='$row[ID]' class='del_btn'><i class='fas fa fa-trash-alt'></i></a></td>
                      </tr>";
                        }
                      }
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- <div class="card-footer">
              <button type="submit" class="btn btn-primary">Delete selected row</button>
              </div> -->
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 col-sm-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add question and answer</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
                <div class="card-body">
                <form action="faqs" method="POST">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Question</label>
                    <input type="text" name="question" class="form-control" id="exampleInputEmail1" placeholder="Enter question">
                  </div>
                  <div class="form-group">
                    <label for="">Answer <small>(max: 1000 characters)</small></label>
                    <textarea class="form-control" placeholder="Enter answer" name="answer" rows="4"></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary" name="add_list">Add to list</button>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>
<script>
$(document).ready(function(){
  $('.del_btn').click(function(e){
    e.preventDefault()
    var parent = $(this).parent('td').parent('tr')
    var pid = $(this).attr('data-id');
    bootbox.dialog({
      size: "medium",
      title: "<i class='fas fa fa-trash-alt'></i> Delete!",
      message: "Do you really want to delete this data ?",
      buttons:{
        cancel_btn:{
          label: "Cancel",
          className: "btn-success",
          callback: function(){
            $('.bootbox').modal('hide')
          }
        },
        confirm_btn:{
          label: "Delete",
          className: "btn-danger",
          callback: function(){
            $.ajax({
              type: "POST",
              url: "deletefaq.php",
              data: "delete="+pid
            })
            .done(function(){
              parent.fadeOut('slow')
            })
            .fail(function(){
              bootbox.alert("Something went wrong...")
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
