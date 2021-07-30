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
       .myimg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
  margin-top: 12px;
  object-fit: cover;
}

.myimg:hover {opacity: 0.7;}

/* The Modal (background) */
.cusmodal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image (Image Text) - Same Width as the Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation - Zoom in the Modal */
.modal-content, #caption {
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes zoom {
  from {transform:scale(0)}
  to {transform:scale(1)}
}


/* The Close Button */
.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
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
                <h2 class='header'>GALLERY</h2>
                <!-- <a class="btn btn-lg round" href="applicationform.php" style="margin-top: 18px; color: <?php echo $row_abt['TextColor']?>; border-color: <?php echo $row_abt['TextColor']?>;">Apply now</a> -->
            </div>
         </div>
     </div>   
    </div>        
</div>
<!-- Gallery section -->
<?php
             $galquery = "SELECT image FROM gallery WHERE school_email = '$schoolkey'";
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
                             echo "<div class='col-md-4 mt-md-4 mt-sm-1'>
                            <img class='myimg' src='../MainDashboard/$gal_row[image]' width = '100%' height='300'>
                            </div>";
                         }
                    echo "</div>
                    </div>
                    ";
                 }
                 else {
                  echo "<div class='container mt-4'>";
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
          <div id="myModal" class="cusmodal">

  <!-- The Close Button -->
  <span class="close">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
</div>
          <!-- End of gallery section -->
          <?php include 'footer.php';?>
      <!-- End of Footer section -->
      <script src="js/main.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
      <script>
// Get the modal
var modal = document.getElementById("myModal");
var imgs = document.querySelectorAll('.myimg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

for (let i = 0; i < imgs.length; i++) {
        imgs[i].addEventListener('click', ()=>{
            let src = imgs[i].getAttribute('src');
            let alt = imgs[i].getAttribute('alt');
            modal.style.display = 'block';
            modalImg.setAttribute('src', src);
            captionText.innerHTML = alt;
        })
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

</script>
</body>
</html>