<?php
include 'connection.php';
include_once 'functions.php';
/* Variable declarions  */

$cat_key = "";
$schools_query = "";
?>



<?php include('header.php'); ?>
<link rel="stylesheet" href="stylesheets/style.css">
<style>
*{
    padding: 0;
      margin: 0;
      box-sizing: border-box;
}
input:focus, textarea:focus, select:focus{
    outline: none;
}
body{
      background-color: #f4f5f7;
    }
.logo{
      object-fit: cover;
      border-radius: 50%;
    }
    .sch-card{
      width: 100%;
      background: white;
      padding: 15px;
      border-radius: 8px;
      border: 1px solid #ccc;
      margin-top: 13px;
    }
    .box{
      display: flex;
    }
    .view{
      background-color: #8b448b;
      color: white;
      padding: 10px;
      border: #8b448b;
      border-radius: 5px;
    }
    .abt{
      margin-top: 10px;
      margin-bottom: 10px;
    }
    .bg-ash{
        background: #e6e6e6;
        color: black;
    }
    .bg-ash:hover{
        background: #d4d4d4;
    }
    @media screen and (max-width: 600px){
      h4{
        font-size: medium;
      }
}


</style>
<!--<script data-ad-client="ca-pub-7381327101505422" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>-->
</head>
<body>
    <?php include('navbar.php'); ?>
    <div class="jumbotron Spage_ad text-center">
        <div class="row justify-content-center">
            <div class="col-md-5">
            <h3>Join other tutors and institutions and start receiving students</h3>
            <a href="register" class="btn btn-outline-light btn-lg round mt-1">Register now</a>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="padding: 15px;">
        <!-- <h3 class="text-center" style="font-family: 'Raleway', sans-serif;">SCHOOLS APPEAR HERE</h3> -->
        
    </div>
    <div class="container-fluid">
        <div class="row" style="margin-bottom: 100px;">
            <div class='col-sm-3'>
                <!--Adds go here-->
            </div>
            <div class="col-sm-6 justify-content-center" >
                <div style="width: 100%;">
        <form action="">
           <div class="input-group">
  <input type="text" class="form-control" name='name' placeholder="Search any tutor/institution name">
  <div class="input-group-append">
    <button class="btn bgcrown btn-sm" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
  </div>
</div>
        </form>
        </div>
            <?php 
            
            // Code section to display all schools registered
            $display = 'block';
            if(isset($_GET['cat']) && $_GET['cat'] !=""){    
                $cat_key = ucfirst($_GET["cat"]);
                $cat_key = check_string($connection, $cat_key);
                $display = 'none';
                $schools_query =  "SELECT Name, address, about, mobile, category, email, profileimg, temp_id FROM basicusers WHERE Status = 'Active' AND category LIKE '%$cat_key%'";
            } 
            else if(isset($_GET['name']) && $_GET['name'] !=""){    
                $cat_key = ucfirst($_GET["name"]);
                $cat_key = check_string($connection, $cat_key);
                $display = 'none';
                $schools_query =  "SELECT Name, address, about, mobile, category, email, profileimg, temp_id FROM basicusers WHERE Status = 'Active' AND Name LIKE '%$cat_key%'";
            } 
                     
             $sch_results = $connection->query($schools_query);
             
             if(!$sch_results){ 
                die ($connection->error);  
            }
             else{
                $rows = $sch_results->num_rows;
                if ($rows < 1) {
                    echo "<h2 id='aboutus' class='center text-center mt-5'><i class='far fa-frown'></i> NO TUTOR OR INSTITUTION WITH THIS NAME OR CATEGORY <i class='far fa-frown'></i></h2>";
                }
                for($i = 0; $i < $rows; $i++){
                    $sch_results->data_seek($i);
                    $row = $sch_results->fetch_array(MYSQLI_ASSOC);
                    $row['about'] = replace_curl($row['about']);
                    $row['Name'] = replace_curl($row['Name']);
                    $row['address'] = replace_curl($row['address']);
                    $row['mobile'] = replace_curl($row['mobile']);
                    $short_abt = $row['about'];
                    $rand = rand();
                    $foldername = get_fname($connection, $row['temp_id']);
                    if(strlen($short_abt) > 140){
                        $short_abt = substr($row['about'], 0, 140).'...';
                    }
                    echo "<div class='sch-card'>
    <div class='box'>
      <img src='MainDashboard/$row[profileimg]?randomurl= $rand' class='logo' alt='' width='40px' height='40px'>
      <div>
      <h5 style='margin-left: 10px;margin-top: 3px;margin-bottom: 0px;'>$row[Name]</h5>
        <small style='margin-left: 10px;color: #7a7979;'>$row[email]</small>
      </div>
    </div>
    <p class='abt'>$short_abt</p>
    <div style='display: flex;'>
    <small style='color: #7a7979;'>#$row[category]</small>
    <a class='btn bg-ash btn-sm p-2' style='margin-left: auto;margin-top: 0px;margin-bottom: 0px;' href='$foldername/index?selector=$row[email]' target='_blank'>View profile &rsaquo;&rsaquo;</a>
    </div>
  </div>";
                }
             } 
            
            ?>
            </div>
            <div class="col-sm-3">
                <!--Adds go here-->
            </div>
        </div>
    </div>
    <?php include('footer.php');?>
</body>
</html>