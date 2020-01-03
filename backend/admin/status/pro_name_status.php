<?php

if(session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['admin_user_id']))
  header("location:../../index.php");

//Include Databse Connection Page
require_once "../database/connection.php";
//Include Finish

if (!empty($_GET['pro_name_id'])) {

    $pro_name_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['pro_name_id']));

    $pro_name_sql = "SELECT * FROM `product_name` WHERE `pro_name_id`='$pro_name_id'";

    if ($pro_name_result = $connection->query($pro_name_sql)) {

        $row_pro_name = $pro_name_result->fetch_assoc();

        if ($row_pro_name['status'] == 1) {
            
            $update_pro_name_sql ="UPDATE `product_name` SET `status`='0' WHERE `pro_name_id`='$pro_name_id'";
            $update_pro_sql ="UPDATE `products` SET `status`='0' WHERE `pro_name_id`='$pro_name_id'";

            if($connection->query($update_pro_name_sql) && $connection->query($update_pro_sql))
                header("location: ../all_product_name.php");
            else
                header("location: ../all_product_name.php");
        }
        else {

            $update_pro_name_sql ="UPDATE `product_name` SET `status`='1' WHERE `pro_name_id`='$pro_name_id'";
            $update_pro_sql ="UPDATE `products` SET `status`='1' WHERE `pro_name_id`='$pro_name_id'";

            if($connection->query($update_pro_name_sql) && $connection->query($update_pro_sql))
                header("location: ../all_product_name.php");
            else
                header("location: ../all_product_name.php"); 
        }                                           
    }
    else
        header("location: ../all_product_name.php");
}
else
    header("location: ../all_product_name.php");

//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function

?>  