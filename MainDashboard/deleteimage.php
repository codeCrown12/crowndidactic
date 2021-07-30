<?php
include_once ('../connection.php');
include_once ('../functions.php');

if(isset($_REQUEST['delete'])){
    $img_id = $_REQUEST['delete'];
    $img_val = $_REQUEST['image'];
    $del_query = "DELETE FROM gallery WHERE ID = $img_id";
    if(file_exists($img_val)){
      unlink($img_val);
      $del_res = $connection->query($del_query);
      if(!$del_res){
        die($connection->error);
        echo "Unable to remove image";
      }
      else{
        echo  "Image removed successfully";
      }
    }
  }
  //End of image upload snippet
?>