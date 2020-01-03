<?php

include_once '../database/connection.php';

if (!empty($_POST['size_types_id'])) {
 	
 	$size_types_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['size_types_id']));
 		
 	$sql_sizes = "SELECT * FROM `sizes` WHERE `size_types_id`='$size_types_id' AND `status`='1'";

 	$data = "<option value=\"\">Choose Size</option>";

 	if ($res_check = $connection->query($sql_sizes)) {
 		if ($res_check->num_rows > 0) {

 			while($row = $res_check->fetch_assoc())
 				$data = $data."<option value=\"$row[size_id]\">$row[size_name]</option>";

 			print $data;
 		}
 		else
 			print $data;
 	}
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