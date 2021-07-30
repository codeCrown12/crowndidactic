<?php
include_once ('../connection.php');
include_once ('../functions.php');
$schoolkey = "";
$info = "";

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
$row_abt['about'] = replace_curl($row_abt['about']);


// Mailer script
require_once '../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'crowndidactic@gmail.com'; 
$mail->Password = 'CROWNdidactic@123';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

if(isset($_POST['send'])){
  if($_POST['email'] == "" || $_POST['name'] == "" || $_POST['subject'] == "" || $_POST['msg'] == ""){
    $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            All fields are required!
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
  }
  else{
    $mail->setFrom($_POST['email'], $_POST['name']);
    $mail->addAddress($schoolkey);
    $mail->isHTML(true);
    $mail->Subject = $_POST['subject'];
    $mail->Body ="<!DOCTYPE html>
    <html lang='en'>
    <head>
      <meta charset='UTF-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0'>
      <title>Message</title>
    </head>
    <body style='background-color: #f8f9fa;padding-bottom: 10px;'>
    <div style='border: solid #fff 1px;width: 75%;padding: 9px;margin-left: auto;margin-right: auto;border-radius: 5px;background-color: white;'>
        <div style='text-align: center;'>
            <p>$_POST[msg]</p>
        </div>
    </div>
    <p style='text-align: center;'><small><span style='color: rgb(114, 113, 113);'>Powered by </span><a href='https://www.crowndidactic.com/' target='_blank'>Crowndidactic</a></small></p>
    <p style='text-align: center;'><small><span style='color: rgb(114, 113, 113);'></span><a href='https://www.crowndidactic.com/Terms/terms' target='_blank'>Privacy policy</a></small></p>
    </body>
    </html>";
    
    if($mail->send()){
      $info = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
            Message sent successfully!
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
    }  
  else{
    $info = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            Error in sending message!
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
  }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact us</title>
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
    <link rel="stylesheet" href="css/contact.css">
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
                <a class="nav-link active" href="contact?selector=<?php echo $schoolkey;?>">Contact</a>
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
    <div class="container mb-5">
        <div class="row justify-content-center mt-5">
            <div class="col-md-9">
                <div class="row justify-content-center mt-3">
                    <div class="col-md-6">
                        <h3 class="caption-txt">Ask us your questions and get feedback!</h3>
            <?php
              $faq_query = "SELECT question, answer FROM faqs_table WHERE school_email = '$schoolkey'";
              $faq_res = $connection->query($faq_query);
              $numrows = $faq_res->num_rows;
              if ($numrows > 1){
                  echo "<div class='accordion accordion-flush mt-4 shadow' id='accordionFlushExample'>";
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
                </div>";
              }
              else{
                  echo "<img class='img-fit' width='100%' src='images/undraw-contact.svg'>";
              }
              ?>
                     
                    </div>
                    <div class="col-md-6">
                        <?php
                            if($info != ""){
                                echo $info;
                            }
                        ?>
                        <form action="contact?selector=<?php echo $schoolkey ?>" method="POST">
                            <div class="mt-3">
                                <input type="text" name="name" id="" class="myform-control" placeholder="Your name">
                            </div>
                            <div class="mt-3">
                                <input type="email" name="email" id="" class="myform-control" placeholder="Email">
                            </div>
                            <div class="mt-3">
                                <input type="text" name="subject" id="" class="myform-control" placeholder="Subject">
                            </div>
                            <div class="mt-3">
                                <textarea type="text" name="msg" style="height: auto;" rows="7" id="" class="myform-control" placeholder="Your message"></textarea>
                            </div>
                            <button type="submit" class="form-btn mt-3" name="send">Send</button>
                        </form>
                    </div>
                </div>  
                <!--<div class="row d-none">-->
                <!--  <div class="box d-flex">-->
                <!--    <p class="d-flex mt-4 me-3"><i class="fas fa-envelope large-icon"></i> <span class="contact-color">name@emailserver.com</span></p>-->
                <!--      <p class="d-flex mt-4 me-3"><i class="fas fa-phone-alt large-icon"></i> <span class="contact-color">+2349017259065</span></p>-->
                <!--      <p class="d-flex mt-4 me-3"><i class="fas fa-map-marker-alt large-icon"></i> <span class="contact-color">Port Harcourt, Nigeria</span></p>-->
                <!--      <p class="d-flex mt-4 me-3"><i class="fas fa-globe-americas large-icon"></i> <span class="contact-color">www.example.com</span></p>-->
                <!--  </div>-->
                <!--</div>-->
            </div>
        </div>
    </div>
    <footer>
        <div class="container">
            <div class="row justify-content-center">
              <div class="col-sm-12">
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
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>