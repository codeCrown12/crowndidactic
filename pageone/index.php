<?php
include_once ('../connection.php');
include_once ('../functions.php');
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
$row_abt['mobile'] = replace_curl($row_abt['mobile']);
$row_abt['about'] = replace_curl($row_abt['about']);
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
body {
    background-color: #f5f5f5;
}
</style>
</head>
<body>
  <?php include 'navbar.php';?>
  <div class="p-5" style="background-color: <?php echo $row_abt['backgroundColor']?>; color: <?php echo $row_abt['TextColor']?>;">
    <div class="container">
     <div class="row justify-content-center p-4">
         <div class="col-md-6">
            <div class="text-center mt-0">
                <h2 class='header'><?php echo $row_abt['caption_text']; ?></h2>
                <?php
                if ($row_abt['applications'] == "On"){
                  echo "<a class='btn btn-lg round' href='applicationform?selector=$schoolkey' style='margin-top: 18px; color:$row_abt[TextColor]; border-color:$row_abt[TextColor]'>Get Started</a>";
                }
                else{
                  echo "<a class='btn btn-lg round' href='appdisabled?selector=$schoolkey' style='margin-top: 18px; color:$row_abt[TextColor]; border-color:$row_abt[TextColor]'>Get Started</a>";
                }
                ?>
            </div>
         </div>
     </div>   
    </div>        
</div>
      <div class="container mt-5">
          <div class="row">
              <div class="col-md-6">
              <div class='img-container'>
                <img class='img_abt' alt='' src='images/About us page-bro.png'>
                </div>
              </div>
              <div class="col-md-6 mb-md-5 mt-md-5 mb-sm-0 mt-sm-0">
                  <div>
                      <h2 class="header" id="aboutus">ABOUT US</h2>
                  </div>
                  <div class="txt_body">
                      <?php if(strlen($row_abt['about']) > 300){
                        echo "<p>".substr($row_abt['about'], 0, 300)."..."."</p>";
                        echo "<p><a href='about?selector=$schoolkey' class='btn btn-md btn-outline-dark'>View more &rsaquo;&rsaquo;</a></p>";
                      }
                      else{
                        echo $row_abt['about'];
                      } 
                      ?>
                  </div>
              </div>
          </div>
          </div>
          <!-- End of gallery section -->

          <!-- features section will be added in next update -->
          
          <!-- End of features section -->
      <!-- Contact section -->
      <div class="container justify-content-center mt-5 mb-5">
        <h3 class="text-center header" id="contactus">SEND US A MESSAGE <i class="fas fa-paper-plane"></i></h3>
      </div>
      <div class="container-fluid contact mt-5 mb-5" id="contactus">
        <div class="container">
          <div class="row">
            <div class="col-sm-5 mb-5">
              <div class="contact-details">
                <div class="form_bodysec">
                  <i class="fas fa-phone-square-alt" style="font-size: 50px;color: <?php echo $row_abt['backgroundColor']?>;"></i>
                  <div class="values" style="margin-left: 25px;">
                    <h3 class="cat_title" style="font-weight: 500;">Call</h3>
                    <p class="small"><?php echo $row_abt['mobile']; ?></p>
                  </div>
                </div>
                <div class="form_bodysec">
                  <i class="fas fa-map-marker-alt" style="font-size: 50px;color: <?php echo $row_abt['backgroundColor']?>;"></i>
                  <div class="values" style="margin-left: 25px;">
                    <h3 class="cat_title" style="font-weight: 500;">Location</h3>
                    <p class="small"><?php echo $row_abt['address']; ?></p>
                  </div>
                </div>
                <div class="form_bodysec">
                  <i class="fas fa-envelope-square" style="font-size: 50px;color: <?php echo $row_abt['backgroundColor']?>;"></i>
                  <div class="values" style="margin-left: 25px;">
                    <h3 class="cat_title" style="font-weight: 500;">Email</h3>
                    <p class="small"><?php echo $row_abt['email']; ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-7">
           <?php if(isset($_GET['error'])) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Sorry!</strong> $_GET[error]
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
    </button>
  </div>";
            }
            if(isset($_GET['success'])) {
              echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> $_GET[success]
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'>
  </button>
</div>";
          }
  ?>
              <form class="row g-3" method="POST" action="mailsend.php">
                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" id="inputEmail4" placeholder="Name">
                </div>
                <div class="col-md-6">
                  <input type="email" name="email" class="form-control" id="inputPassword4" placeholder="Email">
                </div>
                <div class="col-12">
                  <input type="text" name="subject" class="form-control" id="inputAddress" placeholder="Subject">
                </div>
                <div class="col-12">
                  <input type="hidden" name="schurl" class="form-control" id="inputAddress" value="<?php echo $row_abt['email']; ?>"> 
                </div>
                <div class="col-12">
                  <textarea name="msg" class="form-control" cols="30" rows="7" placeholder="Message"></textarea>
                </div>
                <div class="col-12">
                  <button type="submit" name="send" class="btn" style="background-color: <?php echo $row_abt['backgroundColor']?>; border-color: <?php echo $row_abt['backgroundColor']?>; color: <?php echo $row_abt['TextColor']?>;">Send Message</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php
              $faq_query = " SELECT question, answer FROM faqs_table WHERE school_email = '$schoolkey'";
              $faq_res = $connection->query($faq_query);
              $numrows = $faq_res->num_rows;
              if ($numrows > 1){
                echo "<div class='container justify-content-center mt-5' id='faqs'>
                <div class='header text-center'>
                        <h3 id='faqs'>FREQUENTLY ASKED <strong>QUESTIONS</strong></h3>
                      </div>
                </div>";
                echo "<div class='container mb-5'>
                <div class='row'>
                <div class='col-md-6'>
                <div class='img-container'>
                <img class='img_abt' alt='' src='images/Questions-pana.png'>
                </div>
                </div>
                <div class='col-md-6 mt-5'>
                <div class='question-box'>
                <div class='accordion' id='accordionFlushExample'>
                ";
                
                for ($i=0; $i < $numrows; $i++) { 
                  $faq_res->data_seek($i);
                  $faq_row = $faq_res->fetch_array(MYSQLI_ASSOC);
                  $rand_id = rand().$i;
                  echo "<div class='accordion-item'>
                  <h2 class='accordion-header' id='flush-heading-$rand_id'>
                    <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#flush-collapse-$rand_id' aria-expanded='false' aria-controls='flush-collapseTwo'>
                      $faq_row[question]
                    </button>
                  </h2>
                  <div id='flush-collapse-$rand_id' class='accordion-collapse collapse' aria-labelledby='flush-heading-$rand_id' data-bs-parent='#accordionFlushExample'>
                    <div class='accordion-body' style='background: #fff;'>$faq_row[answer]</div>
                  </div>
                </div>";
                }
                echo"
                </div>
                </div>
                </div>
                </div>
                </div>  
                ";
              }
              ?>
     
      <!-- End Contact section -->
<!--      <div id="myModal" class="cusmodal">-->

  <!-- The Close Button -->
<!--  <span class="close">&times;</span>-->

  <!-- Modal Content (The Image) -->
<!--  <img class="modal-content" id="img01">-->

  <!-- Modal Caption (Image Text) -->
<!--  <div id="caption"></div>-->
<!--</div>-->
      <!-- Footer section -->
    <?php include 'footer.php';?>
      <!-- End of Footer section -->
      <script src="js/main.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
</body>
</html>