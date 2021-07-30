<?php

if ($_FILES['image']) {
    $file_name = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $newimg = 'mailedimgs/'.$file_name.".png";
    if(move_uploaded_file($file_tmp, $newimg)){
    $body = "<img src='cid:ImageAdd'>"."<p>$mail_txt</p>";
    $mail->AddEmbeddedImage($newimg, 'ImageAdd', 'ImageAdd');
    echo $newimg;
    }
    else{
      echo "Error";
    }
  }

?>