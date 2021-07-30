<?php
include_once ('../connection.php');
include_once ('../functions.php');


if (isset($_REQUEST['block'])) {
    $email = $_REQUEST['block'];
    $query = "UPDATE basicusers SET Status = 'Inactive' WHERE email = '$email'";
    $result = $connection->query($query);
    if(!$result){
        die($connection->error);
        echo "Unable to block user";
    }
    else{
        echo "User blocked successfully";
    }
}

?>