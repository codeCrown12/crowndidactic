<?php
include_once ('../connection.php');
include_once('../functions.php');
if (isset($_GET['selector']) && $_GET['selector'] != "") {
  $schoolkey = $_GET['selector'];
  $query = "SELECT * FROM basicusers WHERE email = '$schoolkey'";
  $res_abt = $connection->query($query);
  if (!$res_abt) {
    die($connection->error);
  }
  else $row_abt = $res_abt->fetch_array(MYSQLI_ASSOC);
  $row_abt['about'] = replace_curl($row_abt['about']);
  $row_abt['Name'] = replace_curl($row_abt['Name']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row_abt['Name']; 
      ?></title>
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
        background-color: #f5f5f5;
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
<div class="p-5" style="important;background-color: <?php echo $row_abt['backgroundColor']?>; color: <?php echo $row_abt['TextColor']?>;">
    <div class="container">
     <div class="row justify-content-center p-4">
         <div class="col-md-5">
            <div class="text-center mt-0">
                <h2 class='header'>ABOUT US</h2>
                <!-- <a class="btn btn-lg round" href="applicationform.php" style="margin-top: 18px; color: <?php echo $row_abt['TextColor']?>; border-color: <?php echo $row_abt['TextColor']?>;">Apply now</a> -->
            </div>
         </div>
     </div>   
    </div>        
</div>
<div class="container mb-sm-5">
          <div class="row">
              <div class="col-md-6">
              <div class='img-container'>
                <img class='img_abt' alt='' src='images/About us page-bro.png'>
                </div>
              </div>
              <div class="col-md-6 mt-lg-5 mt-sm-1">
                  <div>
                      <h3 class="header" id="aboutus">WHO WE ARE</h3>
                  </div>
                  <div class="txt_body">
                      <?php
                        echo "<p>".$row_abt['about']."</p>"; 
                      ?>
                  </div>
                  <?php
                  $newquery = "SELECT * FROM courses WHERE school_email = '$schoolkey'";
                  $newres = $connection->query($newquery);
                  if (!$newres) {
                    die($connection->error);
                  }
                  else{
                      $numrows = $newres->num_rows;
                      if ($numrows > 0) {
                     echo "<div>
                      <h3 class='header mt-5'>OUR COURSES &#128218;</h3>
                  </div>";
                     echo "<ul>";
                         for ($i=0; $i < $numrows; $i++) {
                             $newres->data_seek($i);
                             $course_row = $newres->fetch_array(MYSQLI_ASSOC);
                             echo "<li>$course_row[course]</li>";
                         }
                    echo "</ul>";
                 }
                  }
                  
                  ?>
              </div>
          </div>
          </div>
<?php include 'footer.php';?>
      <!-- End of Footer section -->
      <script src="js/main.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
</body>
</html>