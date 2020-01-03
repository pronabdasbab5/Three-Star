<?php

if(session_status() === PHP_SESSION_NONE) 
    session_start();

if (empty($_SESSION['admin_user_id']))
  header("location:../../index.php");

//Include Databse Connection Page
require_once "../database/connection.php";
//Include Finish

//User Registration
if(isset($_POST['submit'])){

    $user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
    
    if (!empty($_POST['user_id']) && !empty($_POST['date'])) {

        if (!empty($_POST['order_value'])){
            $order_value = $connection->real_escape_string(mysql_entities_fix_string($_POST['order_value']));
            $order_value_1 = $connection->real_escape_string(mysql_entities_fix_string($_POST['order_value']));
        }
        else{
            $order_value = "";
            $order_value_1 = 0;
        }

        if (!empty($_POST['payment_recieved'])){
            $payment_recieved = $connection->real_escape_string(mysql_entities_fix_string($_POST['payment_recieved']));
            $payment_recieved_1 = $connection->real_escape_string(mysql_entities_fix_string($_POST['payment_recieved']));
        }
        else{
            $payment_recieved = "";
            $payment_recieved_1 = 0;
        }

        if (!empty($_POST['date']))
            $date = $connection->real_escape_string(mysql_entities_fix_string($_POST['date']));
        else
            $date = "";

        $sql_payment = "SELECT SUM(`order_value`) AS total_order, SUM(`payment_recieve`) AS total_payment_recived FROM `payment_report` WHERE `user_id`='$user_id'";
        if($result_payment = $connection->query($sql_payment)) {

            $row_payment = $result_payment->fetch_assoc();
            $total_order_value = $row_payment['total_order'] + $order_value_1;
            $total_payment_recived = $row_payment['total_payment_recived'] + $payment_recieved_1;
            $balance = $total_order_value - $total_payment_recived;

            $payment_report_sql = "INSERT INTO `payment_report` (`user_id`, `order_value`, `payment_recieve`, `balance`, `date`) VALUES ('$user_id', '$order_value', '$payment_recieved', '$balance', '$date')";

            if($connection->query($payment_report_sql)){

                @mkdir("../../account");
                @mkdir("../../account/document");
                if (!empty($_FILES['upload_file']['name'][0])) {

                    /** Payment ID **/
                    $payment_id = $connection->insert_id;

                    for ($i=0; $i < count($_FILES['upload_file']['name']); $i++) { 
                        move_uploaded_file($_FILES['upload_file']['tmp_name'][$i], '../../account/document/'.$_FILES['upload_file']['name'][$i]);

                        $file_name = $_FILES['upload_file']['name'][$i];

                        /** Inserting file data into database **/
                        $payment_report_file_sql = "INSERT INTO `payment_report_file` (`payment_report_id`, `file`) VALUES ('$payment_id', '$file_name')";
                        $connection->query($payment_report_file_sql);
                    }
                }

                header("location: ../payment_report.php?user_id=$user_id&msg=3");  
            }
            else
                header("location: ../payment_report.php?user_id=$user_id&msg=2"); 
        }
        else
            header("location: ../payment_report.php?user_id=$user_id&msg=2"); 
    } else
    	header("location: ../payment_report.php?user_id=$user_id&msg=1");  
}
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