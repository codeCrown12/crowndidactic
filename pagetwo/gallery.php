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
  $row_abt['about'] = replace_curl($row_abt['about']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse images</title>
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
    <link rel="stylesheet" href="css/gallery.css">
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
                <a class="nav-link active" href="gallery?selector=<?php echo $schoolkey;?>">Gallery</a>
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
      <div class="container-fluid mt-5">
          <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-5">
                  <h1 class="caption-txt text-center">Gallery &#128247;</h1>
                  <p class="text-center sub-caption">Browse through the images and get to know us better.</p>
                </div>
            </div>
            <div class="row mt-3">
                <?php
             $galquery = "SELECT image, caption FROM gallery WHERE school_email = '$schoolkey'";
             $gal_res = $connection->query($galquery);
             if(!$gal_res){
               die($connection->error);
             }
             else{
                 $numrows = $gal_res->num_rows;
                 if ($numrows > 0) {
                     echo "<div class='container mt-4'>";
                     echo " <div class='row mb-5'>";
                     
                         for ($i=0; $i < $numrows; $i++) {
                             $gal_res->data_seek($i);
                             $gal_row = $gal_res->fetch_array(MYSQLI_ASSOC);
                             echo "<div class='col-sm-4 mb-4'>
                    <div class='img-cover'>
                        <img src='../MainDashboard/$gal_row[image]' width='100%' class='img-fit img-gal' alt=''>
                    <div class='overlay'>
                        <div class='text'>$gal_row[caption]</div>
                      </div>
                    </div>
                </div>";
                         }
                    echo "</div>
                    </div>
                    ";
                 }
                 else {
                  echo "<div class='container'>";
                  echo " <div class='row mb-5 justify-content-center'>";
                   echo "<div class='col-md-5'>
                   <div class='text-center'>
                   <img src='https://img.icons8.com/cute-clipart/64/000000/no-image.png'/>
                   <div class='header text-center'>
                <h4 id='faqs'>No Images in the gallery</h4>
                </div>
                   </div>
                   </div>
                   </div>
                   </div>
                   ";
                 }
             }
          ?>
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
      <div id="myModal" class="cusmodal">

        <!-- The Close Button -->
        <span class="close">&times;</span>
      
        <!-- Modal Content (The Image) -->
        <img class="modal-content" id="img01">
      
        <!-- Modal Caption (Image Text) -->
        <div id="caption"></div>
      </div>
<script>
// Get the modal
var modal = document.getElementById("myModal");
var imgs = document.querySelectorAll('.img-gal');
var overlay = document.querySelectorAll('.overlay');
var txts = document.querySelectorAll('.text');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

for (let i = 0; i < imgs.length; i++) {
        overlay[i].addEventListener('click', ()=>{
            let src = imgs[i].getAttribute('src');
            modal.style.display = 'block';
            modalImg.setAttribute('src', src);
            captionText.innerHTML = txts[i].innerHTML;
        })
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>