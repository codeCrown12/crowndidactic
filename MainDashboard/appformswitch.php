<?php
session_start();
include '../connection.php';
include '../functions.php';

if(isset($_REQUEST['switch'])){
        $selector = $_SESSION['email'];
        $frm_query = "SELECT applications FROM basicusers WHERE email = '$selector'";
        $frm_res = $connection->query($frm_query);
        if($frm_res){
           $row = $frm_res->fetch_array(MYSQLI_ASSOC);
           if ($row['applications'] == "On") {
               Switch_off($selector, $connection);
           }
           elseif ($row['applications'] == "Off") {
               Switch_on($selector, $connection);
           }
        }
    else {
        echo "No session started";
    }
}


function Switch_off($selector, $connection){
    $query = "UPDATE basicusers SET applications = 'Off' WHERE email = '$selector'";
    $result = $connection->query($query);
    if ($result) {
        echo "Applications turned off";
    }
    else echo "Error in turning off switch";
}

function Switch_on($selector, $connection){
    $query = "UPDATE basicusers SET applications = 'On' WHERE email = '$selector'";
    $result = $connection->query($query);
    if ($result) {
        echo "Applications turned on";
    }
    else echo "Error in turning on switch";
}

?>