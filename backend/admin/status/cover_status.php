<?php

if(session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['admin_user_id']))
  header("location:../../index.php");

//Include Databse Connection Page
require_once "../database/connection.php";
//Include Finish

if (!empty($_GET['cover_id'])) {

    $cover_id = ucwords($connection->real_escape_string(mysql_entities_fix_string($_GET['cover_id'])));

    $cover_sql = "SELECT * FROM `cover` WHERE `cover_id`='$cover_id'";

    if ($cover_result = $connection->query($cover_sql)) {

        $row_cover = $cover_result->fetch_assoc();

        if ($row_cover['status'] == 1) {
            
            $update_cover_sql ="UPDATE `cover` SET `status`='0' WHERE `cover_id`='$cover_id'";
            if($connection->query($update_cover_sql))
                header("location: ../all_cover.php");
            else
                header("location: ../all_cover.php");
        }
        else {

            $update_cover_sql ="UPDATE `cover` SET `status`='1' WHERE `cover_id`='$cover_id'";
            if($connection->query($update_cover_sql))
                header("location: ../all_cover.php");
            else
                header("location: ../all_cover.php");
        }                                           
    }
    else
        header("location: ../all_cover.php");
}
else
    header("location: ../all_cover.php");

//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function

?>  