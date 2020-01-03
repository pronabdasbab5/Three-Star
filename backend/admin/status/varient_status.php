<?php

if(session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['admin_user_id']))
  header("location:../../index.php");

//Include Databse Connection Page
require_once "../database/connection.php";
//Include Finish

if (!empty($_GET['varient_id'])) {

    $varient_id = ucwords($connection->real_escape_string(mysql_entities_fix_string($_GET['varient_id'])));

    $varient_sql = "SELECT * FROM `varient` WHERE `varient_id`='$varient_id'";

    if ($varient_result = $connection->query($varient_sql)) {

        $row_varient = $varient_result->fetch_assoc();

        if ($row_varient['status'] == 1) {
            
            $update_varient_sql ="UPDATE `varient` SET `status`='0' WHERE `varient_id`='$varient_id'";
            if($connection->query($update_varient_sql))
                header("location: ../all_varient.php");
            else
                header("location: ../all_varient.php");
        }
        else {

            $update_varient_sql ="UPDATE `varient` SET `status`='1' WHERE `varient_id`='$varient_id'";
            if($connection->query($update_varient_sql))
                header("location: ../all_varient.php");
            else
                header("location: ../all_varient.php");
        }                                           
    }
    else
        header("location: ../all_varient.php");
}
else
    header("location: ../all_varient.php");

//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function

?>  