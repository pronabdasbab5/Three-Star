<?php

if(session_status() === PHP_SESSION_NONE) 
	session_start();

if (empty($_SESSION['admin_user_id']))
  header("location:../index.php");

//Include Databse Connection Page
require_once "database/connection.php";
//Include Finish

if (!empty($_GET['feature_product_id'])) {

	$feature_product_id = ucwords($connection->real_escape_string(mysql_entities_fix_string($_GET['feature_product_id'])));

	/** Feature Product Count **/
    $feature_product_count_sql = "SELECT * FROM `feature_product`";
   	if ($feature_product_count = $connection->query($feature_product_count_sql)) {

   		$feature_product_count_sql_1 = "SELECT * FROM `feature_product` WHERE `product_id` = '$feature_product_id'";
   		$feature_product_count_1 = $connection->query($feature_product_count_sql_1);

   		if($feature_product_count_1->num_rows > 0)
   			print "<script>window.location.href='all_product_name.php';</script>";
   		else {
   			if($feature_product_count->num_rows <= 10) {
	            $feature_product_add_sql = "INSERT INTO `feature_product` (`product_id`) VALUES ('$feature_product_id')";
	            $connection->query($feature_product_add_sql);
	            print "<script>window.location.href='all_product_name.php'</script>";
	        } else {
	        	$rand_id = rand(1, 10);
	        	$feature_product_update_sql = "UPDATE `feature_product` SET `product_id`='$feature_product_id' WHERE `id`='$rand_id'";
	            $connection->query($feature_product_update_sql);
	            print "<script>window.location.href='all_product_name.php'</script>";
	        }
   		}
    } else
        print "<script>window.location.href='all_product_name.php';</script>";   
}

if (!empty($_GET['best_seller_product_id'])) {

	$best_seller_product_id = ucwords($connection->real_escape_string(mysql_entities_fix_string($_GET['best_seller_product_id'])));

	/** Best Seller Product Count **/
    $best_seller_product_count_sql = "SELECT * FROM `best_seller_product`";
   	if ($best_seller_product_count = $connection->query($best_seller_product_count_sql)) {

   		$best_seller_product_count_sql_1 = "SELECT * FROM `best_seller_product` WHERE `pro_name_id` = '$best_seller_product_id'";
   		$best_seller_product_count_1 = $connection->query($best_seller_product_count_sql_1);

   		if($best_seller_product_count_1->num_rows > 0)
   			print "<script>window.location.href='all_product_name.php';</script>";
   		else {
   			if($best_seller_product_count->num_rows <= 10) {
	            $best_seller_product_add_sql = "INSERT INTO `best_seller_product` (`pro_name_id`) VALUES ('$best_seller_product_id')";
	            $connection->query($best_seller_product_add_sql);
	            print "<script>window.location.href='all_product_name.php'</script>";
	        } else {
	        	$rand_id = rand(1, 10);
	        	$best_seller_product_update_sql = "UPDATE `best_seller_product` SET `pro_name_id`='$best_seller_product_id' WHERE `id`='$rand_id'";
	            $connection->query($best_seller_product_update_sql);
	            print "<script>window.location.href='all_product_name.php'</script>";
	        }
   		}
    } else
        print "<script>window.location.href='all_product_name.php';</script>";   
}

if (!empty($_GET['special_product_id'])) {

	$special_product_id = ucwords($connection->real_escape_string(mysql_entities_fix_string($_GET['special_product_id'])));

	/** Best Seller Product Count **/
    $special_product_count_sql = "SELECT * FROM `special_product`";
   	if ($special_product_count = $connection->query($special_product_count_sql)) {

   		$special_product_count_sql_1 = "SELECT * FROM `special_product` WHERE `product_id` = '$special_product_id'";
   		$special_product_count_1 = $connection->query($special_product_count_sql_1);

   		if($special_product_count_1->num_rows > 0)
   			print "<script>window.location.href='all_product_name.php';</script>";
   		else {
   			if($special_product_count->num_rows <= 10) {
	            $special_product_add_sql = "INSERT INTO `special_product` (`product_id`) VALUES ('$special_product_id')";
	            $connection->query($special_product_add_sql);
	            print "<script>window.location.href='all_product_name.php'</script>";
	        } else {
	        	$rand_id = rand(1, 10);
	        	$special_product_update_sql = "UPDATE `special_product` SET `product_id`='$special_product_id' WHERE `id`='$rand_id'";
	            $connection->query($special_product_update_sql);
	            print "<script>window.location.href='all_product_name.php'</script>";
	        }
   		}
    } else
        print "<script>window.location.href='all_product_name.php';</script>";   
}
//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function
?>