<?php

if(session_status() === PHP_SESSION_NONE) 
    session_start();

if (empty($_SESSION['admin_user_id']))
  header("location:../../index.php");

//Include Databse Connection Page
require_once "../database/connection.php";
//Include Finish

if (!empty($_POST['product_slider_id'])) {

    $product_slider_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['product_slider_id']));

    $sql_product_name_slider = "SELECT * FROM `product_name_slider` WHERE `id`='$product_slider_id'";
    $result_product_name_slider = $connection->query($sql_product_name_slider);
    $row_product_name_slider = $result_product_name_slider->fetch_assoc();

    unlink("../../../product_name_slider/".$row_product_name_slider['slider']);

    $ext = explode(".", $_FILES['slider']['name']);
    $ext = end($ext);
    $ext = strtolower($ext);

    $path = time().".".$ext;
    $product_name_slider_update = "UPDATE `product_name_slider` SET `slider` = '$path' WHERE `id` = '$product_slider_id'";

    if ($connection->query($product_name_slider_update)) {

        move_uploaded_file($_FILES['slider']['tmp_name'], "../../../product_name_slider/".$path);
        header("location: ../product_name_all_slider_image.php?product_name_id=$row_product_name_slider[product_name_id]");
    } else 
        header("location: ../product_name_all_slider_image.php?product_name_id=$row_product_name_slider[product_name_id]");
}
else
    header("location: ../product_name_all_slider_image.php?product_name_id=$row_product_name_slider[product_name_id]");

//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function

?>  