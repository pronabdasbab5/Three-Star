<?php
session_start();

if (empty($_SESSION['user_id'])) 
    header('location: ../index.php');

include "../database/connection.php";

if(!empty($_GET['product_id'])){

	$product_id=$connection->real_escape_string(mysql_entities_fix_string($_GET['product_id']));

	$sql_wishlist = "DELETE FROM `wishlist` WHERE `user_id` = '$_SESSION[user_id]' AND `product_id` = '$product_id'";
	$connection->query($sql_wishlist);

	header("location: ../mywishlist.php");
}

function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
	if (get_magic_quotes_gpc()) 
		$string = stripslashes($string);
	return $string;
}
$connection->close();
?>