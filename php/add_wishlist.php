<?php
session_start();
if(empty($_SESSION['user_id']))
    header('location: ../login.php');
else {

	include "../database/connection.php";
	if(!empty($_GET['product_id'])){

		$product_id=$connection->real_escape_string(mysql_entities_fix_string($_GET['product_id']));

		$sql="select * from `wishlist` where `user_id`='$_SESSION[user_id]' and `product_id`='$product_id'";

		if ($result=$connection->query($sql)) {
	    	$row_cnt=$result->num_rows;
	    	if($row_cnt > 0) {

	    		$exp = explode('/', $_SESSION['page']);
			    $id = $_SESSION['id'];
			    header("location: ../$exp[2]?id=$id");
	    	} else {

	    		$sql_wishlist = "INSERT INTO `wishlist`(`user_id`, `product_id`) VALUES ('$_SESSION[user_id]', '$product_id')";
			    $connection->query($sql_wishlist);

			    $exp = explode('/', $_SESSION['page']);
			    $id = $_SESSION['id'];
			    header("location: ../$exp[2]?id=$id");
	    	}
	    }
	}
	$connection->close();
}

function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
	if (get_magic_quotes_gpc()) 
		$string = stripslashes($string);
	return $string;
}
?>