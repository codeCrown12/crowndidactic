<?php
include_once '../connection.php';
include_once '../functions.php';

$schoolkey = "";
//Snippet to select school information from database
if (isset($_GET['selector']) && $_GET['selector'] != "") {
  $schoolkey = $_GET['selector'];
  $query = "SELECT * FROM basicusers WHERE email = '$schoolkey'";
  $res_abt = $connection->query($query);
  if (!$res_abt) {
    die($connection->error);
  }
  else $row_abt = $res_abt->fetch_array(MYSQLI_ASSOC);
}
//End of snippet

//Code to process application form
$info = "";
if (isset($_POST['submit'])) {
    $fname = check_string($connection, $_POST['fname']);
    $lname = check_string($connection, $_POST['lname']);
    $email = check_string($connection, $_POST['email']);
    $address = check_string($connection, $_POST['address']);
    $mobile = check_string($connection, $_POST['mobile']);
    $dob = check_string($connection, $_POST['dob']);
    $course = check_string($connection, $_POST['course']);
    $date = date('Y-m-d');
    if ($fname == "" || $lname == "" || $email == "" || $address == "" || $mobile == "" || $dob == "" || $course == "-- Select course --") {
        $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            All fields are required.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }
    else if (check_app_email($connection, $schoolkey, $email) == true) {
        $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Email is already used by another applicant
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }
    else{
        $query = "INSERT INTO applicants (school_email, firstname, lastname, email, mobile, dob, address, course, app_date) VALUES (?,?,?,?,?,?,?,?,?)";
        $result = $connection->prepare($query);
        $result->bind_param("sssssssss", $schoolkey, $fname, $lname, $email, $mobile, $dob, $address, $course, $date);
        if ($result->execute()) {
            // header("Location: onepage.php?selector=$schoolkey");
            $info = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            Your Details have been submitted successfully. You will be contacted by the school via email.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
        }
        else{
            echo "<p style='color: red;' class='text-center'><i class='fas fa-exclamation-circle'></i> Connection Error</p>";
        }
    }
}
//End of code snippet
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get in touch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="css/onepage.css">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300&display=swap');
  </style>
    <!-- font awesome css links -->
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/all.css" type="text/css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/all.min.css" type="text/css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/brands.css" type="text/css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/brands.min.css" type="text/css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/../fontawesome.css" type="text/css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/../fontawesome.min.css" type="text/css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/regular.css" type="text/css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/regular.min.css" type="text/css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/solid.css" type="text/css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/solid.min.css" type="text/css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/svg-with-js.css" type="text/css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/svg-with-js.min.css" type="text/css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/v4-shims.css" type="text/css">
    <link rel="stylesheet" href="../fontawesome-free-5.13.0-web/css/v4-shims.min.css" type="text/css">
    <style>
       body{
        background-color: #f8f9fa;
    }
      .site-footer {
      background-color: <?php echo $row_abt['backgroundColor']?>;
      padding: 45px 0 20px;
      font-size: 15px;
      line-height: 24px;
      color: <?php echo $row_abt['TextColor']?>;
  }
  .social-icons a{
  color: <?php echo $row_abt['TextColor']?>;
  font-size:16px;
  display:inline-block;
  line-height:44px;
  width:44px;
  height:44px;
  text-align:center;
  margin-right:8px;
  border-radius:100%;
  -webkit-transition:all .2s linear;
  -o-transition:all .2s linear;
  transition:all .2s linear
  }
  .footer-links a
  {
  color: <?php echo $row_abt['TextColor']?>;
  text-decoration: none;
  }
  .site-footer h6
  {
  color: <?php echo $row_abt['TextColor']?>;
  font-size:16px;
  text-transform:uppercase;
  margin-top:5px;
  letter-spacing:2px
  }
  .site-footer a
  {
  color: <?php echo $row_abt['TextColor']?>;
  }
  </style>
</head>
<body>
  <?php include 'navbar.php';?>
  <div class="container mb-5" style="margin-top: 50px;">
  <div class="row justify-content-md-center">
  <div class="col-md-10">
  <?php
  if ($info != "") {
    echo $info;
  }
  
  ?>
  <div class="card">
  <div class="card-header text-center bg-white">
  <div class="header">
  <img width="100" class="nav-logo" src="<?php echo "../MainDashboard/".$row_abt['profileimg'];?>" alt="">
      <h3 class="mt-1"><strong>GET STARTED</strong></h3>
  </div>
  </div>
  <div class="card-body">
  <form class="row g-3" action="applicationform?selector=<?php echo $schoolkey?>" method="POST">
  <div class="col-md-6">
    <label class="form-label">First Name</label>
    <input name="fname" type="text" class="form-control">
  </div>
  <div class="col-md-6">
    <label class="form-label">Last Name</label>
    <input name="lname" type="text" class="form-control">
  </div>
  <div class="col-12">
    <label class="form-label">Email</label>
    <input name="email" type="email" class="form-control" placeholder="yourusername@mailserver.com">
  </div>
  <div class="col-12">
    <label class="form-label">Course</label>
    <select type="email" class="form-control" name="course">
          <option value="-- Select course --">-- Select course --</option>
          <?php
          $querycourse = "SELECT course FROM courses WHERE school_email = '$schoolkey'";
          $result = $connection->query($querycourse);
          if(!$result) die ($connection->error);
          $rows = $result->num_rows;

            for($i=0; $i<$rows; $i++){
                $result->data_seek($i);
                $row = $result->fetch_array(MYSQLI_ASSOC);
                echo "<option value='".$row['course']."'>".$row['course']."</option>";
                }
                $result->close();
                ?>
          </select>
  </div>
  <div class="col-12">
    <label class="form-label">Address</label>
    <input name="address" type="text" class="form-control"  placeholder="Apartment, studio, or floor">
  </div>
  <div class="col-md-6">
    <label class="form-label">Mobile</label>
    <input name="mobile" type="text" class="form-control">
  </div>
  <div class="col-md-6">
    <label class="form-label">Date of birth</label>
    <input name="dob" type="date" class="form-control">
  </div>
  <div class="col-12 justify-content-md-center">
    <button name="submit" type="submit" class="btn btn-primary">Submit form</button>
  </div>
</form>
  </div>
  </div>
  </div>
  </div>
  </div>
  <?php include 'footer.php';?>
  <script src="js/main.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
</body>
</html>