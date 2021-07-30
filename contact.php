<?php

// Mailer script
require_once 'vendor/autoload.php';
include 'connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer();

$mail->isSMTP();
$mail->Host = 'mail.crowndidactic.com';
$mail->SMTPAuth = true;
$mail->Username = 'info@crowndidactic.com'; 
$mail->Password = 'Passw0rdx123#';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;
$row = "";

$emailConfirm = "";
if(isset($_POST['send'])){
  if($_POST['email'] == "" || $_POST['name'] == "" || $_POST['subject'] == "" || $_POST['msg'] == ""){
    $emailConfirm = "All fields are required!!";
  }
  else{
    $mail->setFrom($_POST['email'], $_POST['name']);
    $mail->addAddress("info@crowndidactic.com");
    $mail->isHTML(true);
    $mail->Subject = $_POST['subject'];
    $mail->Body = $_POST['msg'];
    
    if($mail->send()){
      $emailConfirm = "Message was sent successfully";
    }  
  else{
    $emailConfirm =  "Unable to send mail";
  }
  }
}

$sql = "SELECT mobile, email, address FROM site_info";
$res = $connection->query($sql);
if(!$res){
    $emailConfirm = "Error in connection";
}
else{
    $row = $res->fetch_array(MYSQLI_ASSOC);
}

?>
<?php
include('header.php');
?>
<link rel="stylesheet" href="stylesheets/style.css">
</head>
<body>
<?php include('navbar.php') ?>
    <div class="jumbotron Spage_ad text-center">
        <h3>SEND US A MESSAGE <i class="fas fa-paper-plane"></i></h3>
        <!-- <a href="#" class="btn btn-outline-light btn-lg round">Go Premium+</a> -->
    </div>
    <div class="container-fluid contact mt-5 mb-5" id="contactus">
        <div class="container">
          <div class="row">
            <div class="col-sm-5">
              <div class="contact-details">
                <div class="form_bodysec">
                  <i class="fas fa-phone-square-alt" style="font-size: 50px;color:#614385;"></i>
                  <div class="values" style="margin-left: 25px;">
                    <h3 class="cat_title" style="font-weight: 500;">Call</h3>
                    <p class="small"><?php echo $row['mobile'] ?></p>
                  </div>
                </div>
                <div class="form_bodysec">
                  <i class="fas fa-map-marker-alt" style="font-size: 50px;color:#614385;"></i>
                  <div class="values" style="margin-left: 25px;">
                    <h3 class="cat_title" style="font-weight: 500;">Location</h3>
                    <p class="small"><?php echo $row['address'] ?></p>
                  </div>
                </div>
                <div class="form_bodysec">
                  <i class="fas fa-envelope-square" style="font-size: 50px;color:#614385;"></i>
                  <div class="values" style="margin-left: 25px;">
                    <h3 class="cat_title" style="font-weight: 500;">Email</h3>
                    <p class="small"><?php echo $row['email'] ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-7">
              <div class="form_body">
              <?php  if($emailConfirm == "Message was sent successfully" && $emailConfirm !="") { echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> $emailConfirm
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>"; }
  else if($emailConfirm != "Message was sent successfully" && $emailConfirm !=""){
    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
    <strong>Sorry!</strong> $emailConfirm
    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
      <span aria-hidden='true'>&times;</span>
    </button>
  </div>";
  }
  ?>
                <form action="contact" method="POST">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <input type="text" class="form-control" id="inputEmail4" name="name" placeholder="Name">
                    </div>
                    <div class="form-group col-md-6">
                      <input type="email" class="form-control" id="inputPassword4" name="email" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control" name="subject" id="inputAddress" placeholder="Subject">
                  </div>
                  <div class="form-group">
                    <textarea class="form-control" name="msg" id="exampleFormControlTextarea1" rows="6" placeholder="Message"></textarea>
                  </div>
                  <div class="justify-content-center">
                    <button type="submit" name="send" class="btn bgcrown">Send Message</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include('footer.php'); ?>
</body>