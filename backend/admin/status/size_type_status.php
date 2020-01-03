<?php

if(session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['admin_user_id']))
  header("location:../../index.php");

//Include Databse Connection Page
require_once "../database/connection.php";
//Include Finish

if (!empty($_GET['size_type_id'])) {

    $size_type_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['size_type_id']));

    $size_types_sql = "SELECT * FROM `size_types` WHERE `size_types_id`='$size_type_id'";

    if ($size_types_result = $connection->query($size_types_sql)) {

        $row_size_types = $size_types_result->fetch_assoc();

        if ($row_size_types['status'] == 1) {
            
            $update_size_types_sql ="UPDATE `size_types` SET `status`='0' WHERE `size_types_id`='$size_type_id'";
            if($connection->query($update_size_types_sql))
                header("location: ../all_size_type.php");
            else
                header("location: ../all_size_type.php");
        }
        else {

            $update_size_types_sql ="UPDATE `size_types` SET `status`='1' WHERE `size_types_id`='$size_type_id'";
            if($connection->query($update_size_types_sql))
                header("location: ../all_size_type.php");
            else
                header("location: ../all_size_type.php");
        }                                           
    }
    else
        header("location: ../all_size_type.php");
}
else
    header("location: ../all_size_type.php");

//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function

?>  