<?php
session_start();
include_once ('../connection.php');
include_once ('../functions.php');
$selector = $_SESSION['email'];
if (isset($_REQUEST['clear']) && $_REQUEST['clear'] == "yes") {
    $query = "DELETE FROM applicants WHERE school_email = '$selector'";
    $result = $connection->query($query);
    if (!$result) {
      die($connection->error);
      echo "Error in connection";
    }
    else {
      echo "list cleared successfully";
    }
  }
  
  if (isset($_REQUEST['appmail'])) {
    $email = $_REQUEST['appmail'];
    $query = "DELETE FROM applicants WHERE school_email = '$selector' AND email = '$email'";
    $result = $connection->query($query);
    if (!$result) {
      die($connection->error);
      echo "Error in connection";
    }
    else {
      echo "student removed successfully";
    }
  }

?>