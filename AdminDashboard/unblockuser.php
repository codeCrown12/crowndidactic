<?php
include_once ('../connection.php');
include_once ('../functions.php');


if (isset($_REQUEST['unblock'])) {
    $email = $_REQUEST['unblock'];
    $query = "UPDATE basicusers SET Status = 'Active' WHERE email = '$email'";
    $result = $connection->query($query);
    if(!$result){
        die($connection->error);
        echo "Unable to unblock user";
    }
    else{
        echo "User unblocked successfully";
    }
}

?>