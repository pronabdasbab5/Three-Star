<?php
session_start();

//Include Databse Connection Page
require_once "../database/connection.php";
//Include Finish

if(empty($_SESSION['cart']))
	$cart = array();
else
	$cart = $_SESSION['cart'];

if(!empty($_POST['product_id']) && !empty($_POST['qty']) > 0) {

	for ($i=0; $i < count($_POST['qty']); $i++) { 

		$product_id = $_POST['product_id'][$i];
		if (!empty($_POST['qty'][$i]) || $_POST['qty'][$i] > 0) {
			$sql_stock_check = "SELECT `stock` FROM `products` WHERE `id` = '$product_id'";

		    if ($result_stock_check = $connection->query($sql_stock_check)) {

		    	$row_stock = $result_stock_check->fetch_assoc();

		    	if ($_POST['qty'][$i] <= $row_stock['stock']) {
		    		
		    		$product_id        = $_POST['product_id'][$i];
					$cart[$product_id] += $_POST['qty'][$i];

					if (!empty($_SESSION['user_id'])) {

						$sql_check="SELECT * FROM `cart_user` WHERE `user_id`='$_SESSION[user_id]' AND `product_id`='$product_id'";

				        if ($result_check = $connection->query($sql_check)) {

							$count = $result_check->num_rows;

							if ($count > 0) {

								$sql_stock = "UPDATE `cart_user` SET `qty`='$cart[$product_id]' WHERE `user_id`='$_SESSION[user_id]' AND `product_id`='$product_id'";
								$connection->query($sql_stock);
							}
							else {

								$sql_stock = "INSERT INTO `cart_user` (`user_id`, `product_id`, `qty`) VALUES ('$_SESSION[user_id]', '$product_id', '$cart[$product_id]')";
								$connection->query($sql_stock);
							}
						}
					}

					header("location: ../cart.php");
		    	}
		    	else{
		    		print "<script>alert('Some product out of stock');</script>";
		    		header("location: ../index.php");
		    	}
			}
		}
	}
} else {
	header('location: ../index.php');
}

if(isset($_POST['update_cart'])) {

	for ($i=0; $i < count($_POST['product_id']); $i++) { 

		$product_id = $_POST['product_id'][$i];
		if (!empty($_POST['qty'][$i]) || $_POST['qty'][$i] > 0) {
			$sql_stock_check="SELECT `stock` FROM `products` WHERE `id`='$product_id'";

		    if ($result_stock = $connection->query($sql_stock_check)) {

		    	$row_stock = $result_stock->fetch_assoc();
		    	$qty = $_POST['qty'][$i];

		    	if ($qty <= $row_stock['stock']) {

		    		$product_id        = $_POST['product_id'][$i];
					$cart[$product_id] = $_POST['qty'][$i];

					if (!empty($_SESSION['user_id'])) {

						$sql_check="SELECT * FROM `cart_user` WHERE `user_id`='$_SESSION[user_id]' AND `product_id`='$product_id'";

				        if ($result_stock = $connection->query($sql_check)) {

							$count = $result_stock->num_rows;

							if ($count > 0) {

								$sql_stock = "UPDATE `cart_user` SET `qty`='$cart[$product_id]' WHERE `user_id`='$_SESSION[user_id]' AND `product_id`='$product_id'";
								$connection->query($sql_stock);
							}
							else {

								$sql_stock = "INSERT INTO `cart_user` (`user_id`, `product_id`, `qty`) VALUES ('$_SESSION[user_id]', '$product_id', '$cart[$product_id]')";
								$connection->query($sql_stock);
							}
						}
					}
		    	}	
		    }
		}
	}

	$_SESSION['cart'] = $cart;

	header("location: ../cart.php");
}

if(!empty($_GET['product_id'])) {

	$product_id = $_GET['product_id'];

	if (count($_SESSION['cart']) > 1) {

		if (!empty($_SESSION['user_id'])) {

			$sql_stock = "DELETE FROM `cart_user` WHERE `user_id`='$_SESSION[user_id]' AND `product_id`='$product_id'";
			
			if($connection->query($sql_stock))
				unset($cart[$product_id]);
		}
		else
			unset($cart[$product_id]);

		$_SESSION['cart'] = $cart;

		header("location: ../cart.php");
	}
	else{

		if (!empty($_SESSION['user_id'])) {

			$sql_stock = "DELETE FROM `cart_user` WHERE `user_id`='$_SESSION[user_id]' AND `product_id`='$product_id'";
			
			if($connection->query($sql_stock))
				unset($cart[$product_id]);
		}
		else
			unset($cart[$product_id]);

		$_SESSION['cart'] = $cart;
		
		header("location: ../index.php");
	}
}

$_SESSION['cart'] = $cart;
?>