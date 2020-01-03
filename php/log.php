<?php

include "../database/connection.php";

if(isset($_POST['submit']) && !empty($_POST['username']) && !empty($_POST['pass'])){

	$u_name=$connection->real_escape_string(mysql_entities_fix_string($_POST['username']));
	$pass=$connection->real_escape_string(mysql_entities_fix_string($_POST['pass']));

	$sql="select * from `user` where `contact_no`='$u_name' and `password`='$pass' and `status`=1";

	if ($result=$connection->query($sql)) {
    	$row_cnt=$result->num_rows;
    	if($row_cnt > 0){
			$row=$result->fetch_assoc();
			session_start();

			$_SESSION['name']=$row['name'];
			$_SESSION['user_id']=$row['id'];
            $_SESSION['discount']=$row['discount'];

			if (count($_SESSION['cart']) > 0) {

                foreach ($_SESSION['cart'] as $product_id => $quantity) { 

                    $sql_check="SELECT * FROM `cart_user` WHERE `user_id`='$_SESSION[user_id]' AND `product_id`='$product_id'";

                    if ($result=$connection->query($sql_check)) {

                        $count=$result->num_rows;

                        if ($count > 0) {

                            $sql_stock = "UPDATE `cart_user` SET `qty`='$quantity' WHERE `user_id`='$_SESSION[user_id]' AND `product_id`='$product_id'";
                            $connection->query($sql_stock);
                        }
                        else {

                            $sql_stock = "INSERT INTO `cart_user` (`user_id`, `product_id`, `qty`) VALUES ('$_SESSION[user_id]', '$product_id', '$quantity')";
                            $connection->query($sql_stock);
                        }
                    }
                }
            }
            unset($_SESSION['cart']);

            if(empty($_SESSION['cart']))
                $cart = array();
            else
                $cart = $_SESSION['cart'];

            $sql_cart_user="SELECT * FROM `cart_user` WHERE `user_id`='$_SESSION[user_id]'";

            if ($result_cart_user=$connection->query($sql_cart_user)) {

                while($row_cart_user = $result_cart_user->fetch_assoc()) {

                    $product_id         = $row_cart_user['product_id'];
                    $cart[$product_id]  = $row_cart_user['qty'];
                }
            }

            $_SESSION['cart'] = $cart;

			header("location:../index.php");
		}	
		else
			header("location:../login.php?msg=1");
	}
	else
		header("location:../login.php?msg=2");
}	
else
	header("location:../login.php?msg=3");

function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
	if (get_magic_quotes_gpc()) 
		$string = stripslashes($string);
	return $string;
}
$connection->close();
?>