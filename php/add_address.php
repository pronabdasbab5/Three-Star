<?php
session_start();
include "../database/connection.php";

if(isset($_POST['submit']) && !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['contact_no']) && !empty($_POST['address']) && !empty($_POST['city']) && !empty($_POST['postal_code']) && !empty($_POST['state']) && !empty($_POST['country'])){

	$name=$connection->real_escape_string(mysql_entities_fix_string($_POST['name']));
	$email=$connection->real_escape_string(mysql_entities_fix_string($_POST['email']));
    $contact_no=$connection->real_escape_string(mysql_entities_fix_string($_POST['contact_no']));
    $address=$connection->real_escape_string(mysql_entities_fix_string($_POST['address']));
    $city=$connection->real_escape_string(mysql_entities_fix_string($_POST['city']));
    $postal_code=$connection->real_escape_string(mysql_entities_fix_string($_POST['postal_code']));
    $state=$connection->real_escape_string(mysql_entities_fix_string($_POST['state']));
    $country=$connection->real_escape_string(mysql_entities_fix_string($_POST['country']));

	$sql_address = "INSERT INTO `address` (`user_id`, `name`, `email`, `contact_no`, `address`, `city`, `postal_code`, `state`, `country`) VALUES ('$_SESSION[user_id]', '$name', '$email', '$contact_no', '$address', '$city', '$postal_code', '$state', '$country')";
    
    if ($connection->query($sql_address))
        header("location:../checkout.php");
    else{
        header("location:../checkout.php");
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