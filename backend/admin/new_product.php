<?php

require_once "include/header.php";

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

        $product_sql ="INSERT INTO `products` (`pro_cate_id`, `pro_name_id`, `pro_desc`, `size_id`, `size_type_id`, `varient_id`, `print`, `quantity_in_id`, `standard_packing_in_piece`, `per_piece_price`, `stock`, `created_at`) VALUES ('$product_category_id', '$product_name_id', '$product_description', '$size_id', '$size_types_id', '$varient_id', '$printing', '$quantity_in_id', '$standard_packing_in_piece', '$per_piece_price', '$stock', '$add_date')";

        if ($connection->query($product_sql))
            showMessage(2); 
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
        print "<script>Swal.fire({position: 'top-end', type: 'success', title: 'Product has been uploaded successfully', showConfirmButton: false, timer: 1500})</script>";
    if ($msg == 3)
        print "<script>Swal.fire('Danger', 'Something wrong while uploading.', 'question')</script>";
    if ($msg == 4)
        print "<script>Swal.fire('Info', 'Product already added.')</script>";
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
            <h2>New Product</h2>
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
                                            print "<option value=\"$row_pro_cate[pro_cate_id]\">$row_pro_cate[pro_cate_name]</option>"; 
                                        }
                                    ?>
                                  </select>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="product_name_id">Product Name</label>
                                <select name="product_name_id" id="product_name_id" class="form-control col-md-7 col-xs-12" required>
                                    <option selected disabled>Choose Product Name</option>
                                  </select>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="size_types_id">Size Types</label>
                                <select name="size_types_id" id="size_types_id" class="form-control" required>
                                    <option selected disabled>Choose Size Types</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="size_name">Size</label>
                                <select name="size_id" id="size_name" class="form-control" required>
                                    <option selected disabled>Choose Size</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="varient_id">Varient</label>
                                <select name="varient_id" id="varient_id" class="form-control" required>
                                    <option selected disabled>Choose Varient</option>
                                    <?php
                                    $sql_varient = "SELECT * FROM `varient` WHERE `status`='1' ORDER BY `varient_id` DESC";

                                    if ($result_varient = $connection->query($sql_varient))
                                        while($row_varient = $result_varient->fetch_assoc())
                                            print "<option value=\"$row_varient[varient_id]\">$row_varient[varient]</option>";
                                    ?>
                                  </select>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="printing">Printing</label>
                                <select name="printing" required class="form-control col-md-7 col-xs-12">
                                    <option selected disabled>Choose Printing</option>
                                    <option value="1">Without Printing</option>
                                    <option value="2">NA</option>
                                    <option value="3">Printing</option>
                                    <option value="4">With Printing</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="col-md-6 col-sm-6 col-xs-12 mb-3">
                                <label for="quantity_in_id">Packing System</label>
                                <select name="quantity_in_id" id="quantity_in_id" class="form-control" required>
                                <option selected disabled>Choose Packing System</option>
                                <?php
                                $sql_quantity_in = "SELECT * FROM `quantity_in` WHERE `status`='1' ORDER BY `quantity_in_id` DESC";

                                if ($result_quantity_in = $connection->query($sql_quantity_in))
                                    while($row_quantity_in = $result_quantity_in->fetch_assoc())
                                        print "<option value=\"$row_quantity_in[quantity_in_id]\">$row_quantity_in[quantity_in]</option>";
                                ?>
                              </select>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 mb-3">
                                <label for="stock">Stock</label>
                                <input type="number" name="stock" id="stock" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-row mb-3">
                            <div class="col-md-6 col-sm-6 col-xs-12 mb-3">
                                <label for="standard_packing_in_piece">Standard Packing in Piece</label>
                                <input type="number" min="1" name="standard_packing_in_piece" placeholder="Enter Standard Packing in Piece." class="form-control" required>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 mb-3">
                                <label for="per_piece_price">Per Price Piece (Rs.)</label>
                                <input type="number" min="1" name="per_piece_price" placeholder="Enter Per Price Piece." class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="well" style="overflow: auto">
                        <div class="form-row mb-3">
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                <label for="product_description">Description</label>
                                <textarea name="product_description" class="form-control"  required></textarea>
                            </div>
                        </div>
                    </div>
              </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success">Add Product</button>
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