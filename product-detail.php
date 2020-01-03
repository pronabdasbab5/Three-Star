<?php 
session_start();

/** For Wish List **/
$_SESSION['page'] = $_SERVER['PHP_SELF'];
$_SESSION['id'] = $_GET['id'];

include 'include/header.php';

if (!empty($_GET['id'])){

    $product_name_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['id']));

    $sql_products_name = "SELECT * FROM `product_name` WHERE `pro_name_id`='$product_name_id'";

    if ($result_products_name = $connection->query($sql_products_name))
        $row_products_name = $result_products_name->fetch_assoc();
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
  <!-- HEADER END -->  
  
  <!-- CONTAIN START -->
  <section class="container">
    <div class="pro-page ptb-55">
      <div class="row">
        <div class="col-md-2 col-sm-2 mb-xs-30">
          <div class="fotorama" data-nav="thumbs" data-allowfullscreen="native">
            <a href="#"><img src="product_name_banner/<?php print $row_products_name['banner']; ?>" alt="<?php print $row_products_name['pro_name']; ?>"></a>
            <?php
            $sql_products_name_slider = "SELECT * FROM `product_name_slider` WHERE `product_name_id`='$product_name_id'";

            if ($result_products_name_slider = $connection->query($sql_products_name_slider)){
                while($row_products_name_slider = $result_products_name_slider->fetch_assoc()){
            ?>
            <a href="#"><img src="product_name_banner/<?php print $row_products_name_slider['slider']; ?>" alt="<?php print $row_products_name['pro_name']; ?>"></a>
            <?php
                }
            }
            ?>
          </div>
        </div>
        <div class="col-md-10 col-sm-10">
          <div class="row">
            <div class="col-xs-12">
              <div class="product-detail-main">
                <div class="product-item-details">
                  <h1 class="product-item-name">
                      <?php
                        $sql_pro_name = "SELECT `pro_name` FROM `product_name` WHERE `pro_name_id` = '$product_name_id'";

                        $result_pro_name = $connection->query($sql_pro_name);
                        $row_pro_name = $result_pro_name->fetch_assoc();

                        print $row_pro_name['pro_name'];
                        ?>
                  </h1>
                  <hr class="mtb-20">
                  <div>
                    <form method="POST" autocomplete="off" action="php/add_cart.php">
                    <table id="example" class="display responsive nowrap" style="width:100%">
                        <thead>
                            <tr>
                              <th>Size</th>
                              <th>Varient</th>
                              <th>Print</th>
                              <th>Packing</th>
                              <th>Price</th>
                              <th>Quantity</th>
                              <th>Sub Total</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql_products = "SELECT * FROM `products` WHERE `pro_name_id`='$product_name_id'";

                            if ($result_products = $connection->query($sql_products)){
                                $i = 1;
                                while($row_products = $result_products->fetch_assoc()){
                            ?>
                            <tr>
                                <td>
                                <?php
                                $sql_sizes = "SELECT `size_name` FROM `sizes` WHERE `size_id` = '$row_products[size_id]'";

                                $result_sizes = $connection->query($sql_sizes);
                                $row_sizes = $result_sizes->fetch_assoc();

                                $sql_size_types = "SELECT `size_types` FROM `size_types` WHERE `size_types_id` = '$row_products[size_type_id]'";

                                $result_size_types = $connection->query($sql_size_types);
                                $row_size_types = $result_size_types->fetch_assoc();

                                print $row_sizes['size_name']; print $row_size_types['size_types'];
                                ?>
                                <input type="hidden" name="product_id[]" value="<?php print $row_products['id'] ?>">
                                </td>
                                <td>
                                <?php
                                $sql_varient = "SELECT `varient` FROM `varient` WHERE `varient_id` = '$row_products[varient_id]'";

                                $result_varient = $connection->query($sql_varient);
                                $row_varient = $result_varient->fetch_assoc();

                                print $row_varient['varient'];
                                ?>
                                </td>
                                <td>
                                <?php
                                if ($row_products['print'] == 1) 
                                    $print = "Without Printing";
                                else if($row_products['print'] == 2)
                                    $print = "NA";
                                else if($row_products['print'] == 3)
                                    $print = "Printing";
                                else
                                    $print = "With Printing";

                                print $print;
                                ?>
                                </td>
                                <td>
                                <?php
                                /** Product Packing System **/
                                $sql_quantity_in = "SELECT * FROM `quantity_in` WHERE `quantity_in_id`='$row_products[quantity_in_id]'";

                                if ($result_quantity_in = $connection->query($sql_quantity_in))
                                    $row_quantity_in = $result_quantity_in->fetch_assoc();

                                print $row_products['standard_packing_in_piece']." in 1 ".$row_quantity_in['quantity_in'];
                                ?>

                                <input type="hidden" id="standard_packing_in_piece<?php print $i; ?>" value="<?php print $row_products['standard_packing_in_piece']; ?>">
                                </td>
                                <td>₹ <?php print $row_products['per_piece_price']; ?>
                                    <input type="hidden" id="per_piece_price<?php print $i; ?>" value="<?php print $row_products['per_piece_price']; ?>">
                                </td>
                                <td><input type="number" id="qty<?php print $i; ?>" onkeyup="calculate_sub_total(<?php print $i; ?>)" name="qty[]"></td>
                                <td>₹<font id="sub_total<?php print $i; ?>">0</font></td>
                                <td><a class="btn btn-black" href="php/add_wishlist.php?product_id=<?php print $row_products['id']; ?>">Add to wishlist</a></td>
                            </tr>
                            <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <button type="submit" title="Add to Cart" class="btn btn-black right-side"><span></span>Proceed to Cart</button> 
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- CONTAIN END --> 
   
<?php include 'include/footer.php';?>   
<script type="text/javascript">
function calculate_sub_total(id) {

    var total_price = ($('#standard_packing_in_piece'+id).val() * $('#per_piece_price'+id).val());
    var sub_total = (total_price * $('#qty'+id).val());
    $('#sub_total'+id).text(sub_total);
}
</script>