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
$row_abt['about'] = replace_curl($row_abt['about']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
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
  <link rel="stylesheet" href="css/style.css">
  <style>
        .app-header {
            align-items: flex-end;
        }
        @keyframes bounce {
	0%, 100%, 20%, 50%, 80% {
		-webkit-transform: translateY(0);
		-ms-transform:     translateY(0);
		transform:         translateY(0)
	}
	40% {
		-webkit-transform: translateY(-15px);
		-ms-transform:     translateY(-15px);
		transform:         translateY(-15px)
	}
	60% {
		-webkit-transform: translateY(-5px);
		-ms-transform:     translateY(-5px);
		transform:         translateY(-5px)
	}
}
.caption-btn{
    -webkit-animation-duration: 1s;
  animation-duration: 1s;
  -webkit-animation-fill-mode: both;
  animation-fill-mode: both;
  -webkit-animation-timing-function: ease-in-out;
  animation-timing-function: ease-in-out;
  animation-iteration-count: infinite;
  -webkit-animation-iteration-count: infinite;
}
.caption-btn:hover{
    animation-name: bounce;
  -moz-animation-name: bounce;
}
  </style>
</head>
<body>
  <div class="container-fluid bg-black">
    <div class="container pt-3">
      <div class="nav mt-1">
        <a href="index?selector=<?php echo $schoolkey;?>" class="brand"><img src="<?php echo "../MainDashboard/".$row_abt['profileimg'];?>" alt=""  width="50px" height="50px" class="img-fit img-circle">&nbsp; <?php 
      if(strlen($row_abt['Name']) > 20){
          echo substr($row_abt['Name'],0,20)."...";
      }
      else echo $row_abt['Name']; 
      ?></a>
        <button class="btn nav-toggle" id="navtoggle"><i class='fas fa-bars'></i></button>
        <div class="list-box hide" id="listbox">
          <ul class="nav-list" id="navlist">
            <li class="item active mt-2"><a href="index?selector=<?php echo $schoolkey;?>">Home</a></li>
            <li class="item mt-2"><a href="gallery?selector=<?php echo $schoolkey;?>">Gallery</a></li>
            <li class="item mt-2"><a href="contact?selector=<?php echo $schoolkey;?>">Contact</a></li>
            <li class="item mt-2"><a href="about?selector=<?php echo $schoolkey;?>">About</a></li>
            <li class="item">
                  <a href="<?php
                if ($row_abt['applications'] == "On"){
                  echo "applicationform?selector=$schoolkey";
                }
                else{
                  echo "appdisabled?selector=$schoolkey";
                }
                ?>" class="btn btn-dark" style="color: white;">Get started</a>
             </li>
          </ul>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-sm-5 mt-md-5 mt-sm-0">
          <div class="caption text-center">
              <div class="app-header d-flex">
                  <p id="txt" class="d-none" data-txt="<?php echo $row_abt['caption_text']; ?>"></p>
                  <h1 class="caption-txt"></h1>
              </div>
            <p class='small-caption'><?php if(strlen($row_abt['about']) > 93){
                        echo "<p>".substr($row_abt['about'], 0, 93)."..."."</p>";
                      }
                      else{
                        echo $row_abt['about'];
                      } 
                      ?></p>
            <button class="caption-btn" onclick="location.replace('about?selector=<?php echo $schoolkey;?>')">Learn more</button>
          </div>
        </div>
        <!-- <div class="col-sm-7 mt-3">
          <img class="img-fit hide" src="images/566-removebg-preview.png" alt="" width="100%">
        </div> -->
      </div>
      <div class="row fixed-bottom">
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
  </div>
  <script>
    const toggle = document.querySelector("#navtoggle");
    toggle.addEventListener('click', ()=>{
      const navlist = document.getElementById("listbox");
      if(navlist.classList.toggle('hide') == false){
        toggle.innerHTML = "<i class='fas fa-times'></i>"
      }
      else{
        toggle.innerHTML = "<i class='fas fa-bars'></i>";
      }
    })
    
        var str = document.getElementById('txt')
        var txt = str.getAttribute('data-txt');
        var speed = 100;
        var i = 0;
        function writer(){
            if (i < txt.length) {
                document.querySelector(".caption-txt").innerHTML += txt.charAt(i);
                i++;
                setTimeout(writer, speed)
            }
        }
        writer()
  </script>
</body>
</html>