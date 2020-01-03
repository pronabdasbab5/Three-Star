<?php
if(session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['admin_user_id']))
  header("location:../../index.php");

//Include Databse Connection Page
require_once "../database/connection.php";
//Include Finish

if (!empty($_GET['product_id'])) {

    $product_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['product_id']));

    $pro_sql = "SELECT * FROM `products` WHERE `id`='$product_id'";

    if ($pro_result = $connection->query($pro_sql)) {

        $row_pro = $pro_result->fetch_assoc();

        if ($row_pro['status'] == 1) {
            
            $update_pro_sql ="UPDATE `products` SET `status`='0' WHERE `id`='$product_id'";

            if($connection->query($update_pro_sql))
                print "<script>window.close();window.opener.location.href = window.opener.location.href;</script>";
            else
                print "<script>window.close();window.opener.location.href = window.opener.location.href;</script>";
        }
        else {

            $update_pro_sql ="UPDATE `products` SET `status`='1' WHERE `id`='$product_id'";
            
            if($connection->query($update_pro_sql))
                print "<script>window.close();window.opener.location.href = window.opener.location.href;</script>";
            else
                print "<script>window.close();window.opener.location.href = window.opener.location.href;</script>";
        }                                           
    }
    else
        print "<script>window.close();window.opener.location.href = window.opener.location.href;</script>";
}
else
    print "<script>window.close();window.opener.location.href = window.opener.location.href;</script>";

//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function

?>  