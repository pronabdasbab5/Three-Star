<?php

if(session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['admin_user_id']))
  header("location:../../index.php");

//Include Databse Connection Page
require_once "../database/connection.php";
//Include Finish

if (!empty($_GET['quantity_in_id'])) {

    $quantity_in_id = ucwords($connection->real_escape_string(mysql_entities_fix_string($_GET['quantity_in_id'])));

    $quantity_in_sql = "SELECT * FROM `quantity_in` WHERE `quantity_in_id`='$quantity_in_id'";

    if ($quantity_in_result = $connection->query($quantity_in_sql)) {

        $row_quantity_in = $quantity_in_result->fetch_assoc();

        if ($row_quantity_in['status'] == 1) {
            
            $update_quantity_in_sql ="UPDATE `quantity_in` SET `status`='0' WHERE `quantity_in_id`='$quantity_in_id'";
            if($connection->query($update_quantity_in_sql))
                header("location: ../all_packing_system.php");
            else
                header("location: ../all_packing_system.php");
        }
        else {

            $update_quantity_in_sql ="UPDATE `quantity_in` SET `status`='1' WHERE `quantity_in_id`='$quantity_in_id'";
            if($connection->query($update_quantity_in_sql))
                header("location: ../all_packing_system.php");
            else
                header("location: ../all_packing_system.php");
        }                                           
    }
    else
        header("location: ../all_packing_system.php");
}
else
    header("location: ../all_packing_system.php");

//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function

?>  