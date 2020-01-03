<?php

require_once "include/header.php";

if (!empty($_GET['product_id'])){

    $product_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['product_id']));

    $sql_products = "SELECT * FROM `products` WHERE `id`='$product_id'";

    if ($result_products = $connection->query($sql_products))
        $row_products = $result_products->fetch_assoc();
}

//User Registration
if(isset($_POST['submit'])){

    if (!empty($_POST['product_category_id']) && !empty($_POST['product_name_id']) && !empty($_POST['product_description']) && !empty($_POST['size_types_id']) && !empty($_POST['size_id']) && !empty($_POST['varient_id']) && !empty($_POST['quantity_in_id']) && !empty($_POST['standard_packing_in_piece']) && !empty($_POST['per_piece_price']) && !empty($_POST['printing']) && !empty($_POST['stock'])) {

        $product_category_id   = $connection->real_escape_string(mysql_entities_fix_string($_POST['product_category_id']));
        $product_name_id   = $connection->real_escape_string(mysql_entities_fix_string($_POST['product_name_id']));
        $product_description     = $_POST['product_description'];
        $size_types_id     = $connection->real_escape_string(mysql_entities_fix_string($_POST['size_types_id']));
        $size_id     = $connection->real_escape_string(mysql_entities_fix_string($_POST['size_id']));
        $varient_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['varient_id']));
        $quantity_in_id   = $connection->real_escape_string(mysql_entities_fix_string($_POST['quantity_in_id']));
        $standard_packing_in_piece = $connection->real_escape_string(mysql_entities_fix_string($_POST['standard_packing_in_piece']));
        $per_piece_price   = $connection->real_escape_string(mysql_entities_fix_string($_POST['per_piece_price']));
        $stock   = $connection->real_escape_string(mysql_entities_fix_string($_POST['stock']));
        $printing   = $connection->real_escape_string(mysql_entities_fix_string($_POST['printing']));
        $add_date = date('d-m-Y');

        $product_count_sql_1 = "SELECT * FROM `products` WHERE `pro_cate_id`='$product_category_id' AND `pro_name_id`='$product_name_id' AND `size_type_id`='$size_types_id' AND `size_id`='$size_id' AND `varient_id`='$varient_id' AND `print`='$printing'";

        if ($product_count_1 = $connection->query($product_count_sql_1)) {

            if ($product_count_1->num_rows > 0){

                $product_sql = "UPDATE `products` SET `pro_desc`='$product_description', `standard_packing_in_piece`='$standard_packing_in_piece', `per_piece_price`='$per_piece_price'  WHERE `id`='$product_id'";
                $connection->query($product_sql);

                print "<script>window.close();window.opener.location.href = window.opener.location.href;</script>";
            }
            else {

                $product_sql = "UPDATE `products` SET `pro_desc`='$product_description', `varient_id`='$varient_id', `quantity_in_id`='$quantity_in_id', `standard_packing_in_piece`='$standard_packing_in_piece', `per_piece_price`='$per_piece_price', `print`='$printing'  WHERE `id`='$product_id'";

                if ($connection->query($product_sql)){

                    print "<script>window.close();window.opener.location.href = window.opener.location.href;</script>"; 
                }
                else
                   showMessage(3);  
            }
        }
        else
            showMessage(3);  

    }  else
        showMessage(1);  
}
//End of User Registration

//Start of Messsage Checking Function
function showMessage($msg) {
    if ($msg == 1)
        print "<script>Swal.fire('Warning', 'Please ! Enter required fields', 'question')</script>";
    if ($msg == 2)
        print "<script>Swal.fire({position: 'top-end', type: 'success', title: 'Product has been updated successfully', showConfirmButton: false, timer: 1500})</script>";
    if ($msg == 3)
        print "<script>Swal.fire('Danger', 'Something wrong while updating.', 'question')</script>";
    if ($msg == 4)
        print "<script>Swal.fire('Info', 'Product already available.')</script>";
    if ($msg == 5)
        print "<script>Swal.fire('Warning', 'Upload only image file.')</script>";
}
//End of Messsage Checking Function

//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function

//Start of Thumbnail
function imageResize ($source, $destination, $width, $height) {

    $ext = explode(".", $source);
    $ext = end($ext);
    $ext = strtolower($ext);
    $image = "";

    if ($ext == "jpg" || $ext == "jpeg")
        $image = imagecreatefromjpeg($source);
    if ($ext=="png")
        $image = imagecreatefrompng($source);
    if ($ext=="bmp")
        $image = imagecreatefrombmp($source);
    if ($ext=="gif")
        $image = imagecreatefromgif($source);

    $tmp = imagecreatetruecolor($width, $height);

    imagecopyresized($tmp, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));

    imagejpeg($tmp, $destination);
}
//End of Thumbnail
?>     
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Product</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" class="form-horizontal form-label-left" enctype="multipart/form-data">
                 <div class="well" style="overflow: auto">
                        <div class="form-row mb-3">
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="product_category_id">Category</label>
                                <select name="product_category_id" id="product_category_id" class="form-control" required>
                                    <option selected disabled>Choose Category</option>
                                    <?php
                                    $retrive_pro_cate_sql = "SELECT * FROM `product_category` ORDER BY `pro_cate_id` ASC";

                                    if ($result_pro_cate = $connection->query($retrive_pro_cate_sql)) 
                                        while ($row_pro_cate = $result_pro_cate->fetch_assoc()){

                                            if($row_products['pro_cate_id'] == $row_pro_cate['pro_cate_id'])
                                                print "<option value=\"$row_pro_cate[pro_cate_id]\" selected>$row_pro_cate[pro_cate_name]</option>"; 
                                            else
                                                print "<option value=\"$row_pro_cate[pro_cate_id]\">$row_pro_cate[pro_cate_name]</option>"; 
                                        }
                                    ?>
                                  </select>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="product_name_id">Product Name</label>
                                <select name="product_name_id" id="product_name_id" class="form-control col-md-7 col-xs-12" required>
                                    <option selected disabled>Choose Product Name</option>
                                    <?php
                                    $retrive_product_name_sql = "SELECT * FROM `product_name` WHERE `pro_cate_id`='$row_products[pro_cate_id]' ORDER BY `pro_name_id` ASC";

                                    if ($result_product_name = $connection->query($retrive_product_name_sql)) 
                                        while ($row_product_name = $result_product_name->fetch_assoc()){

                                            if($row_products['pro_name_id'] == $row_product_name['pro_name_id'])
                                                print "<option value=\"$row_product_name[pro_name_id]\" selected>$row_product_name[pro_name]</option>"; 
                                            else
                                                print "<option value=\"$row_product_name[pro_name_id]\">$row_product_name[pro_name]</option>"; 
                                        }
                                    ?>
                                  </select>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="size_types_id">Size Types</label>
                                <select name="size_types_id" id="size_types_id" class="form-control" required>
                                    <option selected disabled>Choose Size Types</option>
                                    <?php
                                    $retrive_size_types_sql = "SELECT * FROM `size_types` WHERE `size_types_id`='$row_products[size_type_id]' ORDER BY `size_types_id` ASC";

                                    if ($result_size_types = $connection->query($retrive_size_types_sql)) 
                                        while ($row_size_types = $result_size_types->fetch_assoc()){

                                            if($row_products['size_type_id'] == $row_size_types['size_types_id'])
                                                print "<option value=\"$row_size_types[size_types_id]\" selected>$row_size_types[size_types]</option>"; 
                                            else
                                                print "<option value=\"$row_size_types[size_types_id]\">$row_size_types[size_types]</option>"; 
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="size_name">Size</label>
                                <select name="size_id" id="size_name" class="form-control" required>
                                    <option selected disabled>Choose Size</option>
                                    <?php
                                    $retrive_sizes_sql = "SELECT * FROM `sizes` WHERE `size_types_id`='$row_products[size_type_id]' ORDER BY `size_id` ASC";

                                    if ($result_sizes = $connection->query($retrive_sizes_sql)) 
                                        while ($row_sizes = $result_sizes->fetch_assoc()){

                                            if($row_products['size_id'] == $row_sizes['size_id'])
                                                print "<option value=\"$row_sizes[size_id]\" selected>$row_sizes[size_name]</option>"; 
                                            else
                                                print "<option value=\"$row_sizes[size_id]\">$row_sizes[size_name]</option>"; 
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="stock">Stock</label>
                                <input type="number" name="stock" id="stock" class="form-control" value="<?php print $row_products['stock']; ?>" required>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="varient_id">Varient</label>
                                <select name="varient_id" id="varient_id" class="form-control" required>
                                    <option selected disabled>Choose Varient</option>
                                    <?php
                                    $sql_varient = "SELECT * FROM `varient` WHERE `status`='1' ORDER BY `varient_id` DESC";

                                    if ($result_varient = $connection->query($sql_varient))
                                        while($row_varient = $result_varient->fetch_assoc()){

                                            if($row_products['varient_id'] == $row_varient['varient_id'])
                                                print "<option value=\"$row_varient[varient_id]\" selected>$row_varient[varient]</option>"; 
                                            else
                                                print "<option value=\"$row_varient[varient_id]\">$row_varient[varient]</option>"; 
                                        }
                                    ?>
                                  </select>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="printing">Printing</label>
                                <select name="printing" required class="form-control col-md-7 col-xs-12">
                                    <?php
                                    if($row_products['varient_id'] == 1)
                                    {
                                    ?>
                                        <option selected disabled>Choose Printing</option>
                                        <option value="1" selected>Without Printing</option>
                                        <option value="2">NA</option>
                                        <option value="3">Printing</option>
                                        <option value="4">With Printing</option>
                                    <?php
                                    }
                                    else if($row_products['varient_id'] == 2)
                                    {
                                    ?>
                                        <option selected disabled>Choose Printing</option>
                                        <option value="1">Without Printing</option>
                                        <option value="2" selected>NA</option>
                                        <option value="3">Printing</option>
                                        <option value="4">With Printing</option>
                                    <?php
                                    }
                                    else if($row_products['varient_id'] == 3)
                                    {
                                    ?>
                                        <option selected disabled>Choose Printing</option>
                                        <option value="1">Without Printing</option>
                                        <option value="2">NA</option>
                                        <option value="3" selected>Printing</option>
                                        <option value="4">With Printing</option>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                        <option selected disabled>Choose Printing</option>
                                        <option value="1">Without Printing</option>
                                        <option value="2">NA</option>
                                        <option value="3">Printing</option>
                                        <option value="4" selected>With Printing</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                   
                        <div class="form-row mb-3">
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="quantity_in_id">Packing System</label>
                                <select name="quantity_in_id" id="quantity_in_id" class="form-control" required>
                                <option selected disabled>Choose Packing System</option>
                                <?php
                                $sql_quantity_in = "SELECT * FROM `quantity_in` WHERE `status`='1' ORDER BY `quantity_in_id` DESC";

                                if ($result_quantity_in = $connection->query($sql_quantity_in))
                                    while($row_quantity_in = $result_quantity_in->fetch_assoc()){

                                        if($row_products['quantity_in_id'] == $row_quantity_in['quantity_in_id'])
                                            print "<option value=\"$row_quantity_in[quantity_in_id]\" selected>$row_quantity_in[quantity_in]</option>"; 
                                        else
                                            print "<option value=\"$row_quantity_in[quantity_in_id]\">$row_quantity_in[quantity_in]</option>";
                                    }
                                ?>
                              </select>
                            </div>
                        </div>

                        <div class="form-row mb-3">
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="standard_packing_in_piece">Standard Packing in Piece</label>
                                <input type="number" min="1" name="standard_packing_in_piece" placeholder="Enter Standard Packing in Piece." class="form-control" value="<?php print $row_products['standard_packing_in_piece']; ?>" required>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="per_piece_price">Per Price Piece (Rs.)</label>
                                <input type="number" min="1" step="0.01" name="per_piece_price" placeholder="Enter Per Price Piece." value="<?php print $row_products['per_piece_price']; ?>" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="well" style="overflow: auto">
                        <div class="form-row mb-3">
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                <label for="product_description">Description</label>
                                <textarea name="product_description" class="form-control"  required><?php print $row_products['pro_desc']; ?></textarea>
                            </div>
                        </div>
                    </div>
              </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success">Save Product</button>
                  </div>
                </div>
            </form>
            <!-- End New User registration -->
            </div>
          </div>
        </div>
      </div>
</div>
<script>
    CKEDITOR.replace( 'product_description' );
</script>
<?php
require_once "include/footer.php";
?>
<script type="text/javascript">
$(document).ready(function(){

    $("#product_category_id").change(function(){

        var product_category_id = $("#product_category_id").val();

        $.ajax({

            method: "POST",
            url   : "ajax/product_category_retrive.php",
            data  : { "product_category_id": product_category_id},
            success: function(response) {
                var res = response.split(',');
                $("#product_name_id").html(res[0]);
                $("#size_types_id").html(res[1]);
            }
        });
    });

    $("#size_types_id").change(function(){

        var size_types_id = $("#size_types_id").val();

        $.ajax({

            method: "POST",
            url   : "ajax/size_retrive.php",
            data  : { "size_types_id": size_types_id},
            success: function(response) {

                $("#size_name").html(response);
            }
        });
    });
});
</script>