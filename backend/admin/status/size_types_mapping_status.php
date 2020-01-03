<?php

if(session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['admin_user_id']))
  header("location:../../index.php");

//Include Databse Connection Page
require_once "../database/connection.php";
//Include Finish

if (!empty($_GET['size_types_mapping_id'])) {

    $size_types_mapping_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['size_types_mapping_id']));

    $category_size_mapping_sql = "SELECT * FROM `category_size_mapping` WHERE `id`='$size_types_mapping_id'";

    if ($category_size_mapping_result = $connection->query($category_size_mapping_sql)) {

        $row_category_size_mapping = $category_size_mapping_result->fetch_assoc();

        if ($row_category_size_mapping['status'] == 1) {
            
            $update_category_size_mapping_sql ="UPDATE `category_size_mapping` SET `status`='0' WHERE `id`='$size_types_mapping_id'";
            if($connection->query($update_category_size_mapping_sql))
                header("location: ../size_type_mapping.php");
            else
                header("location: ../size_type_mapping.php");
        }
        else {

            $update_category_size_mapping_sql ="UPDATE `category_size_mapping` SET `status`='1' WHERE `id`='$size_types_mapping_id'";
            if($connection->query($update_category_size_mapping_sql))
                header("location: ../size_type_mapping.php");
            else
                header("location: ../size_type_mapping.php");
        }                                           
    }
    else
        header("location: ../size_type_mapping.php");
}
else
    header("location: ../size_type_mapping.php");

//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function

?>  