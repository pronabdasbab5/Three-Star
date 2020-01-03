<?php

if(session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['admin_user_id']))
  header("location:../../index.php");

//Include Databse Connection Page
require_once "../database/connection.php";
//Include Finish

if (!empty($_GET['pro_cate_id'])) {

    $pro_cate_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['pro_cate_id']));

    $pro_cate_sql = "SELECT * FROM `product_category` WHERE `pro_cate_id`='$pro_cate_id'";

    if ($pro_cate_result = $connection->query($pro_cate_sql)) {

        $row_pro_cate = $pro_cate_result->fetch_assoc();

        if ($row_pro_cate['status'] == 1) {
            
            $update_pro_cate_sql ="UPDATE `product_category` SET `status`='0' WHERE `pro_cate_id`='$pro_cate_id'";
            $update_pro_sql ="UPDATE `products` SET `status`='0' WHERE `pro_cate_id`='$pro_cate_id'";

            if($connection->query($update_pro_cate_sql) && $connection->query($update_pro_sql))
                header("location: ../all_product_category.php");
            else
                header("location: ../all_product_category.php");
        }
        else {

            $update_pro_cate_sql ="UPDATE `product_category` SET `status`='1' WHERE `pro_cate_id`='$pro_cate_id'";
            $update_pro_sql ="UPDATE `products` SET `status`='1' WHERE `pro_cate_id`='$pro_cate_id'";

            if($connection->query($update_pro_cate_sql) && $connection->query($update_pro_sql))
                header("location: ../all_product_category.php");
            else
                header("location: ../all_product_category.php"); 
        }                                           
    }
    else
        header("location: ../all_product_category.php");
}
else
    header("location: ../all_product_category.php");

//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function

?>  