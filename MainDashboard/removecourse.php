<?php
session_start();
include_once ('../connection.php');
include_once ('../functions.php');


if (isset($_REQUEST['delete'])) {
    $id = $_REQUEST['delete'];
    $query = "DELETE FROM courses WHERE ID = $id";
    $result = $connection->query($query);
    if(!$result){
        die($connection->error);
        echo "Unable to delete data";
    }
    else{
        echo "course removed successfully";
    }
}

?>