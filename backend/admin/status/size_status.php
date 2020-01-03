<?php

if(session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['admin_user_id']))
  header("location:../../index.php");

//Include Databse Connection Page
require_once "../database/connection.php";
//Include Finish

if (!empty($_GET['size_id'])) {

    $size_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['size_id']));

    $size_sql = "SELECT * FROM `sizes` WHERE `size_id`='$size_id'";

    if ($size_result = $connection->query($size_sql)) {

        $row_size = $size_result->fetch_assoc();

        if ($row_size['status'] == 1) {
            
            $update_size_sql ="UPDATE `sizes` SET `status`='0' WHERE `size_id`='$size_id'";
            if($connection->query($update_size_sql))
                header("location: ../all_size.php");
            else
                header("location: ../all_size.php");
        }
        else {

            $update_size_sql ="UPDATE `sizes` SET `status`='1' WHERE `size_id`='$size_id'";
            if($connection->query($update_size_sql))
                header("location: ../all_size.php");
            else
                header("location: ../all_size.php");
        }                                           
    }
    else
        header("location: ../all_size.php");
}
else
    header("location: ../all_size.php");

//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function

?>  