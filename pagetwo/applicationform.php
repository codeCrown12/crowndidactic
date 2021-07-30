<?php
include_once '../connection.php';
include_once '../functions.php';
$row_abt = "";
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

$row_abt['Name'] = replace_curl($row_abt['Name']);
$row_abt['address'] = replace_curl($row_abt['address']);
$row_abt['about'] = replace_curl($row_abt['about']);
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
        $info = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
            All fields are required.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }
    else if (check_app_email($connection, $schoolkey, $email) == true) {
        $info = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
            Email is already used by another applicant
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }
    else{
        $query = "INSERT INTO applicants (school_email, firstname, lastname, email, mobile, dob, address, course, app_date) VALUES (?,?,?,?,?,?,?,?,?)";
        $result = $connection->prepare($query);
        $result->bind_param("sssssssss", $schoolkey, $fname, $lname, $email, $mobile, $dob, $address, $course, $date);
        if ($result->execute()) {
            $info = "<div class='alert alert-success alert-dismissible fade show mt-2' role='alert'>
            Your Details have been submitted successfully! You will be contacted by the school via email.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
        }
        else{
            $info = "<div class='alert alert-danger alert-dismissible fade show mt-2' role='alert'>
            Error in connection
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
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
    <title>Get started</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
          <a class="navbar-brand ms-lg-5" href="index?selector=<?php echo $schoolkey;?>"><img src="<?php echo "../MainDashboard/".$row_abt['profileimg'];?>" alt=""  width="50px" height="50px" class="img-fit img-circle">&nbsp; <?php 
      if(strlen($row_abt['Name']) > 20){
          echo substr($row_abt['Name'],0,20)."...";
      }
      else echo $row_abt['Name']; 
      ?></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto me-5">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index?selector=<?php echo $schoolkey;?>">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="gallery?selector=<?php echo $schoolkey;?>">Gallery</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact?selector=<?php echo $schoolkey;?>">Contact</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about?selector=<?php echo $schoolkey;?>" tabindex="-1">About</a>
              </li>
              <li class="nav-item">
                  <a href="<?php
                if ($row_abt['applications'] == "On"){
                  echo "applicationform?selector=$schoolkey";
                }
                else{
                  echo "appdisabled?selector=$schoolkey";
                }
                ?>" class="btn btn-dark">Get started</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <div class="container mb-4">
          <div class="row justify-content-center">
              <div class="col-sm-11">
                  <div class="form-box mt-4 shadow">
                      <div class="info">
                        <div class="inner">
                            <h3 class="caption-txt">Fill the form, and start learning!</h3>
                            <p class="mt-3">For further information, please use the info below to contact us.</p>
                            <div class="dbox w-100 d-flex align-items-center">
                                <div class="icon-circle d-flex align-items-center justify-content-center">
                                <span class="fa fa-map-marker"></span>
                                </div>
                                <div class="text">
                                <p><span class="title">Address:</span> <?php echo $row_abt['address']; ?></p>
                                </div>
                            </div>
                            <div class="dbox w-100 d-flex align-items-center">
                                <div class="icon-circle d-flex align-items-center justify-content-center">
                                <span class="fa fa-phone"></span>
                                </div>
                                <div class="text">
                                <p><span class="title">Phone:</span> <?php echo $row_abt['mobile']; ?></p>
                                </div>
                            </div>
                            <div class="dbox w-100 d-flex align-items-center">
                                <div class="icon-circle d-flex align-items-center justify-content-center">
                                <span class="fa fa-paper-plane"></span>
                                </div>
                                <div class="text">
                                <p><span class="title">Email:</span> <?php echo $row_abt['email']; ?></p>
                                </div>
                            </div>
                            <div class="dbox w-100 d-flex align-items-center">
                                <div class="icon-circle d-flex align-items-center justify-content-center">
                                <span class="fa fa-globe"></span>
                                </div>
                                <div class="text">
                                <p><span class="title">Website:</span> <a href="="<?php
                                    if ($row_abt['weburl'] == "Website URL goes here") {
                                      echo "#";
                                    }
                                    else{
                                        echo $row_abt['weburl'];
                                    }
                                    ?>" target="_blank"><?php
                                    if ($row_abt['weburl'] == "Website URL goes here") {
                                      echo "No website link";
                                    }
                                    else{
                                        echo $row_abt['weburl'];
                                    }
                                    ?></a></p>
                                </div>
                            </div>
                        </div>
                      </div>
                      <div class="frmsection">
                      <?php
                        if($info != ""){
                            echo $info;
                        }
                      ?>
                        <form class="row g-3 mt-1 mb-3" method="POST" action="applicationform?selector=<?php echo $schoolkey ?>">
                            <div class="col-md-6">
                              <label class="myfrmlabel">First Name</label>
                              <input type="text" name="fname" class="myformctrl">
                            </div>
                            <div class="col-md-6">
                                <label class="myfrmlabel">Last Name</label>
                                <input type="text" name="lname" class="myformctrl">
                              </div>
                            <div class="col-md-12">
                                <label class="myfrmlabel">Email</label>
                                <input type="email" name="email" class="myformctrl">
                            </div>
                            <div class="col-md-12">
                                <label for="inputEmail4" class="myfrmlabel">Address</label>
                                <input type="text" name="address" class="myformctrl" id="inputEmail4">
                            </div>
                            <div class="col-md-6">
                                <label class="myfrmlabel">Mobile</label>
                                <input type="tel" name="mobile" class="myformctrl">
                              </div>
                              <div class="col-md-6">
                                  <label class="myfrmlabel">Date of birth</label>
                                  <input type="date" name="dob" class="myformctrl">
                                </div>
                            <div class="col-md-12">
                                <label for="inputEmail4" class="myfrmlabel">Course</label>
                                <select name="course" class="myformctrl">
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
                            <div class="col-md-12">
                                <button class="mybtn mt-3" type="submit" name="submit">Submit</button>
                            </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <ul class="social-icons">
            <li><a href="
            <?php
                if ($row_abt['facebook'] == "facebook link") {
                  echo "#";
                }
                else{
                    echo $row_abt['facebook'];
                }
                ?>" class="icon facebook" style="padding-left: 10px;padding-right: 10px;"><i class='fa fa-facebook'></i></a></li>
            <li><a href="
            <?php
                if ($row_abt['twitter'] == "twitter link") {
                  echo "#";
                }
                else{
                    echo $row_abt['twitter'];
                }
                ?>" class="icon twitter"><i class='fa fa-twitter'></i></a></li>
            <li><a href="<?php
                if ($row_abt['linkedin'] == "linkedIn link") {
                  echo "#";
                }
                else{
                    echo $row_abt['linkedin'];
                }
                ?>" class="icon linkedin" style="padding-left: 8px;padding-right: 8px;"><i class='fa fa-linkedin'></i></a></li>
            <li><a href="<?php
                if ($row_abt['instagram'] == "instagram link") {
                  echo "#";
                }
                else{
                    echo $row_abt['instagram'];
                }
                ?>" class="icon instagram" style="padding-left: 7px;padding-right: 7px;"><i class='fa fa-instagram'></i></a></li>
          </ul>
      <p class="footnote"><small>Powered by <a href="https://www.crowndidactic.com" target="_blank">crowndidactic</a></small></p>
       <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>