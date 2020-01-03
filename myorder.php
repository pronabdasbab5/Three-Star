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
        <div class="col-sm-10 mp-0 wishlist">
          <div class="cart-item-table commun-table">
            <!-- col start -->
            <?php
            if(!empty($_GET['page']) > 0)
                $page = $_GET['page'];
            else
                $page = 1;

            $limit = ($page * 2) - 2;

            $sql_order = $connection->query("SELECT * FROM `orders` WHERE `user_id` = '$_SESSION[user_id]' ORDER BY `id` DESC limit $limit, 2");
            while($row_order = $sql_order->fetch_assoc()) {
            ?>
            <table class="display table-responsive dataTable mb-xs-30" style="width:100%;border: 10px solid #eee">
              <!-- THEAD -->
              <thead>
                    <tr>
                      <th colspan="2">Order Status : <b style="color: #fff;background: green;padding: 0 3px">
                          <?php
                        if ($row_order['status'] == 1)
                            print "New Order";
                        
                        if ($row_order['status'] == 2)
                            print "<span class=\"label label-warning\">Accept Order</span>";

                        if ($row_order['status'] == 3)
                            print "<span class=\"label label-danger\">Cancel Order</span>";
                        ?>
                      </b></th>
                      <th colspan="2">Order ID : <?php print $row_order['order_id']; ?></th>
                      <th colspan="2">Order Date : <?php print $row_order['payment_date']; ?></th>
                    </tr>
                    <tr>
                      <th class="wd-150">Product Name</th>
                      <th>Size</th>
                      <th>Varient</th>
                      <th>Print</th>
                      <th>Packing</th>
                      <th>Price</th>
                    </tr>
              </thead><!-- END THEAD -->
              <!-- TBODY -->
              <tbody>
                <?php
                $sql_order_detail = $connection->query("SELECT * FROM `order_details` WHERE `order_id` = '$row_order[id]'");

                $total = 0;
                while($row_order_detail = $sql_order_detail->fetch_assoc()) {

                    /** Product Detail **/
                    $sql_product_detail = $connection->query("select * from `products` where `id` = '$row_order_detail[product_id]'");
                    $row_product_detail = $sql_product_detail->fetch_assoc();

                    /** Product Cover Image **/
                    $sql_product_cover = "SELECT * FROM `products_cover` WHERE `product_id`='$row_order_detail[product_id]'";
                    if ($result_product_cover = $connection->query($sql_product_cover))
                        $row_product_cover = $result_product_cover->fetch_assoc();

                    /** Product Name **/
                    $sql_product_name = $connection->query("select * from `product_name` where  `product_name`.`pro_name_id` = '$row_product_detail[pro_name_id]'");
                    $row_product_name = $sql_product_name->fetch_assoc();

                    /** Product Size **/
                    $sql_size = $connection->query("select * from `sizes` where `size_id` = '$row_product_detail[size_id]'");
                    $row_size = $sql_size->fetch_assoc();

                    /** Product Size Types **/
                    $sql_size_types = $connection->query("select * from `size_types` where `size_types_id` = '$row_product_detail[size_type_id]'");
                    $row_size_types = $sql_size_types->fetch_assoc();

                    /** Varient **/
                    $sql_varient = $connection->query("select * from `varient` where `varient_id` = '$row_product_detail[varient_id]'");
                    $row_varient = $sql_varient->fetch_assoc();

                    /** Printing **/
                    if ($row_product_detail['print'] == 1) 
                        $printing = "Without Printing";
                    else if($row_product_detail['print'] == 2)
                        $printing = "NA";
                    else if($row_product_detail['print'] == 3)
                        $printing = "Printing";
                    else
                        $printing = "With Printing";

                    /** Product Packing System **/
                    $sql_quantity_in = "SELECT * FROM `quantity_in` WHERE `quantity_in_id`='$row_product_detail[quantity_in_id]'";

                    if ($result_quantity_in = $connection->query($sql_quantity_in))
                        $row_quantity_in = $result_quantity_in->fetch_assoc();
                ?>
                  <tr>
                      <td class="wd-150 no-white-space">
                          <?php print $row_product_name['pro_name']; ?>
                      </td>
                      <td>
                        <?php print $row_size['size_name']; ?> <?php print $row_size_types['size_types']; ?>
                      </td>
                      <td>
                          <?php print  $row_varient['varient']; ?>
                      </td>
                      <td>
                          <?php print $printing; ?>
                      </td>
                      <td>
                          <?php
                          print $row_product_detail['standard_packing_in_piece']." in 1 ".$row_quantity_in['quantity_in'];
                          ?>
                      </td>
                      <td>₹ <?php print $row_product_detail['per_piece_price']; ?></td>
                  </tr>
                <?php
                    }
                ?>
              </tbody> <!-- END TBODY -->
              <!-- TFOOT -->
              <tbody>
                <tr>
                  <th colspan="9" style="border-top: 1px solid #333;">Total: ₹ <?php print $row_order['total_amount']; ?></th>
                </tr>
              </tbody><!-- END TFOOT -->
              <!-- TDIVIDER -->
              <tbody class="table-divider">
                <td colspan="9" class="divider"><hr></td>
              </tbody><!-- END TDIVIDER --> 
            </table>
            <?php
            }
            ?>            
            <!-- col start -->
          </div>
        </div>        
        <div class="col-sm-1"></div>
      </div>
      <div class="row">
            <div class="col-xs-12">
              <div class="pagination-bar">
                <ul>
                    <?php

                    $sql_2 = $connection->query("SELECT * FROM `orders` WHERE `user_id` = '$_SESSION[user_id]' ORDER BY `id` DESC");

                    $total=$sql_2->num_rows;

                    if($page > 1){

                        $prev = $page - 1;

                        print "<li><a href=\"myorder.php?page=$prev\"><i class=\"fa fa-angle-left\"></i></a></li>";
                    }

                    $no_page = ceil($total/2);

                    for($i = 1; $i <= $no_page; $i++){

                        if($page == $i)
                            print "<li class=\"active\"><a href=\"myorder.php?page=$i\">$i</a></li>";
                        else
                            print "<li><a href=\"myorder.php?page=$i\">$i</a></li>";
                    }

                    if($page < $no_page){

                        $next = $page + 1;
                                        
                        print "<li><a href=\"myorder.php?page=$next\"><i class=\"fa fa-angle-right\"></i></a></li>";
                    }
                    ?>
                </ul>
              </div>
            </div>
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