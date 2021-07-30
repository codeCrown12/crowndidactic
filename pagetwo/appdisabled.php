<?php
$school_key = "";
if (isset($_GET['selector'])) {
    $school_key = $_GET['selector'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get started</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="css/onepage.css">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@100;200;300&display=swap');
  </style>
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
        background-color: #f8f9fa;
    }
    </style>
</head>
<body>
<div class="container" style="margin-top: 100px;">
    <div class="text-center mb-3">
    <h1 style="font-family: 'Raleway', sans-serif;">Sorry!!</h1>
  </div>
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
        <div class="card bg-white p-4">
            <div class="card-body">
            <h3 style="font-weight: normal;font-size: 25px;font-family: 'Raleway', sans-serif;">We are currently not accepting applications at the moment.</h3>
            <a href="index?selector=<?php echo $school_key ?>" class="btn btn-success mt-2"><i class="fas fa-arrow-left"></i> Back to site</a>
            </div>
        </div>
        </div>
    </div>
    </div>
</body>
</html>