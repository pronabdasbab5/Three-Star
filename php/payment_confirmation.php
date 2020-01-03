<?php
session_start();
if (empty($_SESSION['user_id'])) 
    header('location: ../login.php');

if (empty($_SESSION['cart'])) 
    header('location: ../index.php');

include "../database/connection.php";

if(isset($_POST['submit']) && !empty($_POST['payment_type'])){

	$payment_type=ucwords(strtolower($connection->real_escape_string(mysql_entities_fix_string($_POST['payment_type']))));

    if ($payment_type == "Offline") {
        
        if (!empty($_SESSION['cart'])) {
            if( count($_SESSION['cart']) > 0 ){

                $total = 0;
                foreach ($_SESSION['cart'] as $product_id => $quantity) {
                    if($sql_product = $connection->query("select `products`.*, `product_name`.`banner`, `product_name`.`pro_name` from `products`, `product_name` where `products`.`id` = '$product_id' and `products`.`pro_name_id` = `product_name`.`pro_name_id`")){
                        while($row_product = $sql_product->fetch_assoc()){
                            
                            $total_pieces = ($row_product['standard_packing_in_piece'] * $quantity);
                            $sub_total = ($row_product['per_piece_price'] * $total_pieces);

                            $total = $total + $sub_total;
                        }
                    }
                }

                if (!empty($_SESSION['discount'])) {
                    $discount = ($total * $_SESSION['discount']) / 100;
                    $total = $total - $discount;
                }
            }
        }

        $order_id = strtoupper(uniqid('#'));
        $payment_date = date('d-m-Y');

        $sql_order = "INSERT INTO `orders` (`order_id`, `user_id`, `address_id`, `total_amount`, `discount`, `payment_date`, `payment_type`) VALUES ('$order_id', '$_SESSION[user_id]', '$_SESSION[address_id]', '$total', '$_SESSION[discount]', '$payment_date', '$payment_type')";
        
        if ($connection->query($sql_order)){

            $order_id = $connection->insert_id;

            if (!empty($_SESSION['cart'])) {
                if( count($_SESSION['cart']) > 0 ){

                    foreach ($_SESSION['cart'] as $product_id => $quantity) {
                        if($sql_product = $connection->query("select `products`.*, `product_name`.`banner`, `product_name`.`pro_name` from `products`, `product_name` where `products`.`id` = '$product_id' and `products`.`pro_name_id` = `product_name`.`pro_name_id`")){
                            while($row_product = $sql_product->fetch_assoc()){
                                
                                $sql_order_details = "INSERT INTO `order_details` (`order_id`, `product_id`, `qty`, `price`) VALUES ('$order_id', '$product_id', '$quantity', '$row_product[per_piece_price]')";

                                $connection->query($sql_order_details);

                                for ($i=0; $i < $quantity; $i++) { 
                                    
                                    $sql_product_1 = $connection->query("select * from `products` where `id` = '$row_product[id]'");
                                    $row_product_1 = $sql_product_1->fetch_assoc();

                                    if ($row_product_1['stock'] > 0) {
                                        $sql_stock_update = "UPDATE `products` SET `stock` = `stock` - 1 WHERE `id` = '$row_product[id]'";

                                        $connection->query($sql_stock_update);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $sql_cart_delete = "DELETE FROM `cart_user` WHERE `user_id`='$_SESSION[user_id]'";
            $connection->query($sql_cart_delete);

            unset($_SESSION['cart']);
            header("location:../confirmation.php");
        }
        else
            header("location:../payment.php");
    } else {

        if (!empty($_SESSION['cart'])) {
            if( count($_SESSION['cart']) > 0 ){

                $total = 0;
                foreach ($_SESSION['cart'] as $product_id => $quantity) {
                    if($sql_product = $connection->query("select `products`.*, `product_name`.`banner`, `product_name`.`pro_name` from `products`, `product_name` where `products`.`id` = '$product_id' and `products`.`pro_name_id` = `product_name`.`pro_name_id`")){
                        while($row_product = $sql_product->fetch_assoc()){
                            
                            $total_pieces = ($row_product['standard_packing_in_piece'] * $quantity);
                            $sub_total = ($row_product['per_piece_price'] * $total_pieces);

                            $total = $total + $sub_total;
                        }
                    }
                }

                if (!empty($_SESSION['discount'])) {
                    $discount = ($total * $_SESSION['discount']) / 100;
                    $total = $total - $discount;
                }

                /** Extra Discount **/
                $discount = ($total * 2) / 100;
                $total = $total - $discount;
            }
        }

        $order_id = strtoupper(uniqid('#'));
        $payment_date = date('d-m-Y');

        $sql_order = "INSERT INTO `orders` (`order_id`, `user_id`, `address_id`, `total_amount`, `discount`, `payment_status`, `payment_date`, `payment_type`) VALUES ('$order_id', '$_SESSION[user_id]', '$_SESSION[address_id]', '$total', '$_SESSION[discount]', 2, '$payment_date', '$payment_type')";
        
        if ($connection->query($sql_order)){

            $order_id = $connection->insert_id;

            if (!empty($_SESSION['cart'])) {
                if( count($_SESSION['cart']) > 0 ){

                    foreach ($_SESSION['cart'] as $product_id => $quantity) {
                        if($sql_product = $connection->query("select `products`.*, `product_name`.`banner`, `product_name`.`pro_name` from `products`, `product_name` where `products`.`id` = '$product_id' and `products`.`pro_name_id` = `product_name`.`pro_name_id`")){
                            while($row_product = $sql_product->fetch_assoc()){
                                
                                $sql_order_details = "INSERT INTO `order_details` (`order_id`, `product_id`, `qty`, `price`) VALUES ('$order_id', '$product_id', '$quantity', '$row_product[per_piece_price]')";

                                $connection->query($sql_order_details);

                                for ($i=0; $i < $quantity; $i++) { 
                                    
                                    $sql_product_1 = $connection->query("select * from `products` where `id` = '$row_product[id]'");
                                    $row_product_1 = $sql_product_1->fetch_assoc();

                                    if ($row_product_1['stock'] > 0) {
                                        $sql_stock_update = "UPDATE `products` SET `stock` = `stock` - 1 WHERE `id` = '$row_product[id]'";

                                        $connection->query($sql_stock_update);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            $sql_cart_delete = "DELETE FROM `cart_user` WHERE `user_id`='$_SESSION[user_id]'";
            $connection->query($sql_cart_delete);

            unset($_SESSION['cart']);

            /** User Info. **/
            $sql_user = $connection->query("select * from `user` where `id` = '$_SESSION[user_id]'");
            $row_user = $sql_user->fetch_assoc();
            $date = date('d-m-Y');

            /** Payment Gateway **/
            include '../include/instamojo/src/instamojo.php';
                
            $api = new Instamojo\Instamojo('test_b5f1dcc0b298b946511a6fba16f', 'test_0ede8bf63667edbace9d7798834','https://test.instamojo.com/api/1.1/');
                
                
            try {
                $response = $api->paymentRequestCreate(array(
                    "purpose" => "For purchasing product",
                    "amount" => $total,
                    "buyer_name" => $row_user['name'],
                    "phone" => $row_user['contact_no'],
                    "send_email" => true,
                    "send_sms" => true,
                    "email" => $row_user['email'],
                    'allow_repeated_payments' => false,
                    "redirect_url" => "http://localhost/three_star/thankyou.php",
                    // "webhook" => "http://localhost/three_star/webhook.php"
                ));
                
                $pay_ulr = $response['longurl'];
                    
                //Redirect($response['longurl'],302); //Go to Payment page
                    
                $sql_update_payment_info = "UPDATE `orders` SET `payment_request_id`='$response[id]' WHERE `id`='$order_id' AND `user_id`='$_SESSION[user_id]'";
                mysqli_query($connection, $sql_update_payment_info);
                
                header("Location: $pay_ulr");
                exit();
                
            }
            catch (Exception $e) {
                print('Error: ' . $e->getMessage());
            } 
        }
        else
            header("location:../payment.php");
    }
}

function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
	if (get_magic_quotes_gpc()) 
		$string = stripslashes($string);
	return $string;
}
$connection->close();
?>