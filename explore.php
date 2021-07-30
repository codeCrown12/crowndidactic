<?php 
include 'connection.php';
include 'functions.php';
?>
<?php include('header.php'); ?>
<link rel="stylesheet" href="stylesheets/style.css">
<style>
body{
      background-color: #f4f5f7;
    }
    .cat{
    border: solid 1px #ccc;
    background: #ffffff;
    border-radius: 6px;
    height: fit-content;
}
.cat:hover{
    transition: .5s ease;
    border: 0;
    cursor: pointer;
    border-radius: 6px;
background: #ffffff;
/*box-shadow:  20px 20px 60px #d9d9d9,*/
/*             -20px -20px 60px #ffffff;*/
}
.box-link, .box-link:hover {
      text-decoration: none;
      color: inherit;
}
@media only screen and (max-width: 768px){
    .cat{
        height: auto;
    }
}
</style>
</head>
<body>
    <?php include('navbar.php'); ?>
    <div class="jumbotron Spage_ad text-center">
        <div class="row justify-content-center">
            <div class="col-md-5">
            <h3>Find tutors and institutions in all categories, and start learning!</h3>
            <!--<a href="register" class="btn btn-outline-light btn-lg round mt-1">Register now</a>-->
            </div>
        </div>
    </div>
    <div class='container mb-5'>
        <h3 class='text-center'>ALL CATEGORIES &#128203;</h3>
            <?php
             $cat_newsql = "SELECT * FROM categories WHERE category <> 'others'";
        $cat_newres = $connection->query($cat_newsql);
        if(!$cat_newres){
            die($connection->error);
        }
        else{
            $num_cat = $cat_newres->num_rows;
            if($num_cat < 1){
                echo "No categories available";
            }
            else{
                echo "<div class='row'>";
                for($i = 0; $i < $num_cat; $i++){
                    $cat_newres->data_seek($i);
                    $data = $cat_newres->fetch_array(MYSQLI_ASSOC);
                    echo "<div class='col-sm-4 mt-4'>
                <a class='box-link' href='searchSchool?cat=$data[category]'><div class='cat p-4'>
                    <h5 class='text-center'>$data[category]</h5>
                </div></a>
            </div>";
                }
                echo "</div>";
            }
        }
            ?>
    </div>
    <?php include('footer.php');?>
</body>
</html>