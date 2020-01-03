<?php
session_start();
if (empty($_SESSION['user_id']))
    header('location: login.php');

if (empty($_SESSION['cart']))
    header('location: index.php');
 
include 'include/header.php';
?>
  <!-- CONTAINER START -->

  <section class="container cart">
    <div class="pb-55 pt-30">
      <div class="row">
        <div class="checkout-step mb-40">
          <ul>
            <li class="active">
              <a href="cart.php">
                <div class="step">
                  <div class="line"></div>
                  <div class="circle">1</div>
                </div>
                <span style="color: #ff6666;font-weight: 700;">Cart</span>
              </a>
            </li>
            <li>
              <a href="checkout.php">
                <div class="step">
                  <div class="line"></div>
                  <div class="circle">2</div>
                </div>
                <span class="hidden-xs" style="font-weight: 500!important;color: #2a2931;">Shipping</span>
              </a>
            </li>
            <li>
              <a>
                <div class="step">
                  <div class="line"></div>
                  <div class="circle">3</div>
                </div>
                <span class="hidden-xs" style="font-weight: 500!important;color: #2a2931;">Payment</span>
              </a>
            </li>
            <li>
              <a>
                <div class="step">
                  <div class="line"></div>
                  <div class="circle">4</div>
                </div>
                <span class="hidden-xs" style="font-weight: 500!important;color: #2a2931;">Order Confirmation</span>
              </a>
            </li>
          </ul>
          <hr>
        </div>
        <form method="POST" action="php/add_cart.php" autocomplete="off">
          <div class="col-sm-12 mb-xs-30">
            <table id="example" class="display responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                      <th class="wd-150">Product Name</th>
                      <th>Size</th>
                      <th>Varient</th>
                      <th>Print</th>
                      <th>Packing</th>
                      <th>Price</th>
                      <th>Quantity</th>
                      <th>Sub Total</th>
                      <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($_SESSION['cart'])) {
                        if( count($_SESSION['cart']) > 0 ){

                            $total = 0;

                            foreach ($_SESSION['cart'] as $product_id => $quantity) {
                                    if($sql_product = $connection->query("select `products`.*, `product_name`.`banner`, `product_name`.`pro_name` from `products`, `product_name` where `products`.`id` = '$product_id' and `products`.`pro_name_id` = `product_name`.`pro_name_id`")){
                                while($row_product = $sql_product->fetch_assoc()){
                    ?>
                    <tr>
                        <td class="wd-150 no-white-space">
                            <?php
                            $sql_pro_name = "SELECT `pro_name` FROM `product_name` WHERE `pro_name_id` = '$row_product[pro_name_id]'";

                            $result_pro_name = $connection->query($sql_pro_name);
                            $row_pro_name = $result_pro_name->fetch_assoc();

                            print $row_pro_name['pro_name'];
                            ?> 
                            <input type="hidden" name="product_id[]" value="<?php print $product_id; ?>" required>
                        </td>
                        <td>
                            <?php
                            $sql_sizes = "SELECT `size_name` FROM `sizes` WHERE `size_id` = '$row_product[size_id]'";

                            $result_sizes = $connection->query($sql_sizes);
                            $row_sizes = $result_sizes->fetch_assoc();

                            $sql_size_types = "SELECT `size_types` FROM `size_types` WHERE `size_types_id` = '$row_product[size_type_id]'";

                            $result_size_types = $connection->query($sql_size_types);
                            $row_size_types = $result_size_types->fetch_assoc();

                            print $row_sizes['size_name']; print $row_size_types['size_types'];
                            ?>
                        </td>
                        <td>
                            <?php
                            $sql_varient = "SELECT `varient` FROM `varient` WHERE `varient_id` = '$row_product[varient_id]'";

                            $result_varient = $connection->query($sql_varient);
                            $row_varient = $result_varient->fetch_assoc();

                            print $row_varient['varient'];
                            ?>
                        </td>
                        <td>
                            <?php
                            if ($row_product['print'] == 1) 
                                $print = "Without Printing";
                            else if($row_product['print'] == 2)
                                $print = "NA";
                            else if($row_product['print'] == 3)
                                $print = "Printing";
                            else
                                $print = "With Printing";

                            print $print;
                            ?>
                        </td>
                        <td>
                            <?php
                            /** Product Packing System **/
                            $sql_quantity_in = "SELECT * FROM `quantity_in` WHERE `quantity_in_id`='$row_product[quantity_in_id]'";

                            if ($result_quantity_in = $connection->query($sql_quantity_in))
                                $row_quantity_in = $result_quantity_in->fetch_assoc();

                            print $row_product['standard_packing_in_piece']." in 1 ".$row_quantity_in['quantity_in'];
                            ?>
                        </td>
                        <td>
                            ₹<?php print $row_product['per_piece_price']; ?>
                                    <input type="hidden" id="per_piece_price<?php print $i; ?>" value="<?php print $row_product['per_piece_price']; ?>">
                        </td>
                        <td><input type="number" name="qty[]" value="<?php print $quantity; ?>" required></td>
                        <td>
                            <?php
                            $total_pices = $row_product['standard_packing_in_piece'] * $quantity;
                            $sub_total = $total_pices * $row_product['per_piece_price'];

                            $total = $total + $sub_total;
                            ?>
                            ₹ <?php print $sub_total; ?>
                        </td>
                        <td><a href="php/add_cart.php?product_id=<?php print $product_id; ?>">Remove</a></td>
                    </tr>
                    <?php
                                    }
                                }
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
          </div>  
          <div class="col-sm-6 no-pad "></div>              
          <div class="col-sm-6 no-pad ">
            <div class="cart-total-table commun-table">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th colspan="2">Cart Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Item(s) Subtotal</td>
                      <td>
                        <div class="price-box">
                          <span class="price">₹ <?php print $total;?> </span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Discount Amount</td>
                      <td>
                        <div class="price-box">
                          <span class="price">
                              <?php
                              if (!empty($_SESSION['discount'])) {
                                $discount = ($total * $_SESSION['discount']) / 100;

                                print "₹ $discount";
                              } else
                                print "₹ 0";
                              ?>
                          </span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Amount Payable</b></td>
                      <td>
                        <div class="price-box">
                          <span class="price">
                            <b>
                                ₹ <?php
                                $payable_amount = $total - $discount;

                                print $payable_amount;
                                ?>
                            </b>
                            </span>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td><button type="submit" name="update_cart" class="btn btn-black btn-lg right-side">Update Cart</button></td>                    
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="mb-30">
        <div class="row">
          <div class="col-xs-6 p-0">
            <div class="mt-30">
              <a href="index.php" class="btn btn-black">Continue Shopping</a>
            </div>
          </div>
          <div class="col-xs-6 p-0">
            <div class="mt-30 right-side float-none-xs">
              <a href="checkout.php" class="btn btn-black">Proceed to checkout</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTAINER END -->
<?php include 'include/footer.php';?>  
 
 
