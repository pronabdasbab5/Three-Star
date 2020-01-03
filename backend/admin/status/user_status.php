<?php
if(session_status() === PHP_SESSION_NONE) 
    session_start();

if (empty($_SESSION['admin_user_id']))
  header("location:../../index.php");

//Include Databse Connection Page
require_once "../database/connection.php";
//Include Finish

if (!empty($_GET['user_id'])) {

    $user_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['user_id']));

    $user_sql = "SELECT * FROM `user` WHERE `id`='$user_id'";

    if ($user_result = $connection->query($user_sql)) {

        $row_user = $user_result->fetch_assoc();

        if ($row_user['status'] == 1) {
            
            $update_user_sql ="UPDATE `user` SET `status`='0' WHERE `id`='$user_id'";
            if($connection->query($update_user_sql))
                header("location: ../all_user.php");
            else
                header("location: ../all_user.php");
        }
        else {

            $update_user_sql ="UPDATE `user` SET `status`='1' WHERE `id`='$user_id'";
            if($connection->query($update_user_sql))
                header("location: ../all_user.php");
            else
                header("location: ../all_user.php");
        }                                           
    }
    else
        header("location: ../all_user.php");
}
else
    header("location: ../all_user.php");

//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function

?>  