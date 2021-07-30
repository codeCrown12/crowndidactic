<?php
// function to sanitize input strings from forms
function check_string($con, $string){
    $string = $con->real_escape_string($string);
    $string = strip_tags($string);
    $string = stripslashes($string);
    return $string;
}

//function to check if email already exists in the database
function email_exists($email){
    include 'connection.php';
    $query = "SELECT email FROM basicusers WHERE email = '$email'";
    $result = $connection->query($query);
    $rows = $result->num_rows;
    for($i=0; $i<$rows; $i++){
        $result->data_seek($i);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if($row['email'] == $email){
            return true;
        }
        else return false;
    }
}

//function to prevent duplicate member email
function admin_email_exists($email){
    include 'connection.php';
    $query = "SELECT email FROM admin_users WHERE email = '$email'";
    $result = $connection->query($query);
    $rows = $result->num_rows;
    for($i=0; $i<$rows; $i++){
        $result->data_seek($i);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if($row['email'] == $email){
            return true;
        }
        else return false;
    }
}

//function to prevent duplicate member username
function uname_exists($uname){
    include 'connection.php';
    $query = "SELECT username FROM admin_users WHERE username = '$uname'";
    $result = $connection->query($query);
    $rows = $result->num_rows;
    for($i=0; $i<$rows; $i++){
        $result->data_seek($i);
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if($row['username'] == $uname){
            return true;
        }
        else return false;
    }
}

//function to update school categories
function update_school_cat($cat, $selector){
    include 'connection.php';
    $query = "UPDATE basicusers SET category = '$cat' WHERE email = '$selector'";
    $result = $connection->query($query);
     if(!$result){
         die($connection->error);
         return false;
     }
     else{
         return true;
     }
  }

  //function to deactivate account 
function deactivate_acct($selector, $connection){
    $query = "UPDATE basicusers SET Status = 'Inactive' WHERE email = '$selector'";
    $result = $connection->query($query);
     if(!$result){
         die($connection->error);
         return false;
     }
     else{
         return true;
     }
}

//function to verify applicant(students) email
function check_app_email($connection, $school_key, $app_email){
    $query = "SELECT email FROM applicants WHERE email = '$app_email' AND school_email = '$school_key'";
    $result = $connection->query($query);
    $rows = $result->num_rows;
    if ($rows < 1) {
        return false;
    }
    else{
        return true;
    }
}

//function to replace curls
function replace_curl($string){
    $string =  str_replace("~", "'", $string);
    return $string;
}

//function to generate pin
function gen_pin(){
    $rand_num =  rand(6, 12);
    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $pin = substr(str_shuffle($permitted_chars), 0, $rand_num);
    return $pin;
    }
    
//function to change gallery key
function update_gal_key($connection, $oldemail, $newemail){
   $query = "UPDATE gallery SET school_email = '$newemail' WHERE school_email = '$oldemail'";
    $result = $connection->query($query);
     if(!$result){
         die($connection->error);
         return false;
     }
     else{
         return true;
     }
}

//function to change faqs_table key
function update_faqs_key($connection, $oldemail, $newemail){
   $query = "UPDATE faqs_table SET school_email = '$newemail' WHERE school_email = '$oldemail'";
    $result = $connection->query($query);
     if(!$result){
         die($connection->error);
         return false;
     }
     else{
         return true;
     }
}

//function to change applicants table key
function update_apps_key($connection, $oldemail, $newemail){
   $query = "UPDATE applicants SET school_email = '$newemail' WHERE school_email = '$oldemail'";
    $result = $connection->query($query);
     if(!$result){
         die($connection->error);
         return false;
     }
     else{
         return true;
     }
}

//function to change feedbacks table key
function update_feedbacks_key($connection, $oldemail, $newemail){
   $query = "UPDATE feedbacks SET school_email = '$newemail' WHERE school_email = '$oldemail'";
    $result = $connection->query($query);
     if(!$result){
         die($connection->error);
         return false;
     }
     else{
         return true;
     }
}

//function to change courses table key
function update_courses_key($connection, $oldemail, $newemail){
   $query = "UPDATE courses SET school_email = '$newemail' WHERE school_email = '$oldemail'";
    $result = $connection->query($query);
     if(!$result){
         die($connection->error);
         return false;
     }
     else{
         return true;
     }
}

//function to get template foldername
function get_fname($connection, $tempid){
    $query = "SELECT folder_name FROM templates WHERE ID = $tempid";
    $result = $connection->query($query);
     if(!$result){
         die($connection->error);
         return false;
     }
     else{
         $row = $result->fetch_array(MYSQLI_ASSOC);
         return $row['folder_name'];
     }
}
?>