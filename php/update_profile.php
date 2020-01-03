<?php
session_start();
if (empty($_SESSION['user_id'])) 
    header('location: ../login.php');

//Include Databse Connection Page
require_once "../database/connection.php";
//Include Finish

//User Registration
if(isset($_POST['submit'])){

    if (!empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['con_password']) && !empty($_POST['address'])) {
        
        $password = $connection->real_escape_string(mysql_entities_fix_string($_POST['password']));
        $con_password = $connection->real_escape_string(mysql_entities_fix_string($_POST['con_password']));
        $name = ucwords(strtolower($connection->real_escape_string(mysql_entities_fix_string($_POST['name']))));
        $address = $connection->real_escape_string(mysql_entities_fix_string($_POST['address']));

        if (!empty($_POST['co_firm_name']))
            $firm_name = $connection->real_escape_string(mysql_entities_fix_string($_POST['co_firm_name']));
        else
            $firm_name = "";

        if (!empty($_POST['alter_no']))
            $alter_no = $connection->real_escape_string(mysql_entities_fix_string($_POST['alter_no']));
        else
            $alter_no = "";

        if (!empty($_POST['email']))
            $email = $connection->real_escape_string(mysql_entities_fix_string($_POST['email']));
        else
            $email = "";

        if (!empty($_POST['gst_no']))
            $gst_no = $connection->real_escape_string(mysql_entities_fix_string($_POST['gst_no']));
        else
            $gst_no = "";

        if ($password == $con_password) {
            
            $update_sql = "UPDATE `user` SET `name_of_firm`='$firm_name', `name` = '$name', `email` = '$email', `contact_no` = '$contact_no', `password` = '$password', `gst_no` = '$gst_no', `address` = '$address', `alter_no` = '$alter_no' WHERE `id`='$_SESSION[user_id]'";

            if($connection->query($update_sql))
                header('location: ../my_account.php?msg=4');  
            else
                header('location: ../my_account.php?msg=3');   
        } else
            header('location: ../my_account.php?msg=2'); 
    } else
        header('location: ../my_account.php?msg=1');  
} else
    header('location: ../my_account.php');  
//End of User Registration

//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function
?>     