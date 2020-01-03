<?php

if(session_status() === PHP_SESSION_NONE) 
    session_start();

if (empty($_SESSION['admin_user_id']))
  header("location:../../index.php");

//Include Databse Connection Page
require_once "../database/connection.php";
//Include Finish

if (!empty($_GET['order_id'])) {

    $order_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['order_id']));

    $order_update_sql ="UPDATE `orders` SET `status`='2' WHERE `id`='$order_id'";
    
    if($connection->query($order_update_sql))
        header("location: ../new_orders.php");
    else
        header("location: ../new_orders.php");
}
else
    header("location: ../new_orders.php");

//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function

?>  