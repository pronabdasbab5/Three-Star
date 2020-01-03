<?php

include_once '../database/connection.php';

if (!empty($_POST['product_category_id'])) {
 	
 	$product_category_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['product_category_id']));
 		
 	$sql_product_name = "SELECT * FROM `product_name` WHERE `pro_cate_id`='$product_category_id' AND `status`='1'";

 	$data = "<option value=\"\">Choose Product Name</option>";

 	if ($res_check = $connection->query($sql_product_name)) {
 		if ($res_check->num_rows > 0) {

 			while($row = $res_check->fetch_assoc())
 				$data = $data."<option value=\"$row[pro_name_id]\">$row[pro_name]</option>";
 		}
 	}

 	print $data;
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