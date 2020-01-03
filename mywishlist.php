<?php 
include 'include/header.php';

if (empty($_SESSION['user_id'])) 
    print "<script>window.location.href='login.php'</script>";

?>
  <!-- CONTAINER START -->

  <section class="container">
    <div class="pb-55 pt-55">
      <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10 mb-xs-30 wishlist">
          <div class="cart-item-table commun-table">
            <!-- col start -->
            <table id="example" class="display responsive nowrap" style="width:100%;border: 10px solid #eee">
              <thead style="border-bottom: 1px solid #333">
                    <tr>
                      <th class="wd-150">Product Name</th>
                      <th>Size</th>
                      <th>Varient</th>
                      <th>Print</th>
                      <th>Packing</th>
                      <th>Price</th>
                      <th>View</th>
                      <th>Remove</th>
                    </tr>
              </thead>
              <tbody>
                <?php
                if($sql_wishlist = $connection->query("select `products`.* from `wishlist`, `products` where `wishlist`.`product_id` = `products`.`id` and `wishlist`.`user_id`='$_SESSION[user_id]'")){
                while($row = $sql_wishlist->fetch_assoc()){

                    /** Product Name **/
                    $sql_2 = $connection->query("select * from `product_name` where  `product_name`.`pro_name_id` = '$row[pro_name_id]'");
                        $row_product_name = $sql_2->fetch_assoc();
                ?>
                  <tr>
                      <td class="wd-150 no-white-space">
                          <?php print $row_product_name['pro_name']; ?>
                      </td>
                      <td>
                           <?php
                            $sql_sizes = "SELECT `size_name` FROM `sizes` WHERE `size_id` = '$row[size_id]'";

                            $result_sizes = $connection->query($sql_sizes);
                                $row_sizes = $result_sizes->fetch_assoc();

                            $sql_size_types = "SELECT `size_types` FROM `size_types` WHERE `size_types_id` = '$row[size_type_id]'";

                            $result_size_types = $connection->query($sql_size_types);
                            $row_size_types = $result_size_types->fetch_assoc();

                            print $row_sizes['size_name']; print $row_size_types['size_types'];
                            ?>
                            <input type="hidden" name="product_id[]" value="<?php print $row['id'] ?>">
                      </td>
                      <td>
                        <?php
                        $sql_varient = "SELECT `varient` FROM `varient` WHERE `varient_id` = '$row[varient_id]'";

                        $result_varient = $connection->query($sql_varient);
                        $row_varient = $result_varient->fetch_assoc();

                        print $row_varient['varient'];
                        ?>  
                      </td>
                      <td>
                        <?php
                        if ($row['print'] == 1) 
                                    $print = "Without Printing";
                        else if($row['print'] == 2)
                            $print = "NA";
                        else if($row['print'] == 3)
                            $print = "Printing";
                        else
                            $print = "With Printing";

                        print $print;
                        ?>
                      </td>
                      <td>
                        <?php
                        /** Product Packing System **/
                        $sql_quantity_in = "SELECT * FROM `quantity_in` WHERE `quantity_in_id`='$row[quantity_in_id]'";

                        if ($result_quantity_in = $connection->query($sql_quantity_in))
                            $row_quantity_in = $result_quantity_in->fetch_assoc();

                        print $row['standard_packing_in_piece']." in 1 ".$row_quantity_in['quantity_in'];
                        ?>
                      </td>
                      <td>₹ <?php print $row['per_piece_price']; ?></td>
                      <td><a class="btn btn-black" href="product-detail.php?id=<?php print $row['pro_name_id']; ?>">View</a></td>
                      <td><a class="btn btn-black" href="php/remove_wishlist_item.php?product_id=<?php print $row['id']; ?>">Remove</a></td>
                  </tr>
                <?php
                        }
                    }
                ?>
              </tbody>
            </table>
            <!-- col start -->
          </div>
        </div>        
        <div class="col-sm-1"></div>
      </div>
      <div class="mb-30">
        <div class="row">
          <div class="col-xs-12 p-0 flex-center">
            <div class="mt-30">
              <a href="index.php" class="btn btn-black">Continue Shopping</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTAINER END -->
<?php include 'include/footer.php';?>