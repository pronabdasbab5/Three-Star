<?php

require_once "include/header.php";

if (!empty($_GET['order_id'])){

    $order_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['order_id']));

    $sql_invoice = "SELECT `orders`.*, `user`.`name`, `user`.`contact_no`, `user`.`email`, `user`.`discount` FROM `orders`, `user` WHERE `orders`.`user_id` = `user`.`id` AND `orders`.`id` = '$order_id'";

    $result_invoice = $connection->query($sql_invoice);
    $row_invoice = $result_invoice->fetch_assoc();

    $sql_address = "SELECT * FROM `address` WHERE `id` = '$row_invoice[address_id]'";

    $result_address = $connection->query($sql_address);
    $row_address = $result_address->fetch_assoc();
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
<style type="text/css">
@print {
    @page :footer {
        display: none
    }

    @page :header {
        display: none
    }
}
</style>
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Invoice</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <section class="content invoice">
                        <div id="printableArea">
                      <!-- info row -->
                      <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                          From
                            <address>
                                <strong>3 Star</strong>
                                <br>Guwahati
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                          To
                          <address>
                            <strong><?php print $row_address['name']; ?></strong>
                            <br>Phone: <?php print $row_address['contact_no']; ?>
                            <br>Email: <?php print $row_address['email']; ?>
                            <br>Address: <?php print $row_address['address']; ?>
                            <br>City: <?php print $row_address['city']; ?>, <?php print $row_address['postal_code']; ?>
                            <br>State: <?php print $row_address['state']; ?>, Country: <?php print $row_address['country']; ?>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                          <b>Order ID:</b> <?php print $row_invoice['order_id']; ?>
                          <br>
                          <b>Payment Due:</b> <?php print $row_invoice['payment_date']; ?>
                          <br>
                          <b>Payment Type:</b> <?php print ucwords($row_invoice['payment_type']); ?>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <!-- Table row -->
                      <div class="row">
                        <div class="col-xs-12 table">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>Qty</th>
                                <th>Product</th>
                                <th>Size Types</th>
                                <th>Sizes</th>
                                <th>Varient</th>
                                <th>Print</th>
                                <th>Packing System</th>
                                <th>Qty</th>
                                <th>Pieces</th>
                                <th>Subtotal</th>
                              </tr>
                            </thead>
                            <tbody>
                               <?php
                            
                                $sql_order_details = "SELECT `products`.*, `order_details`.`qty`, `order_details`.`price` as order_price FROM `order_details`, `products` WHERE `order_details`.`order_id` = '$order_id' AND `order_details`.`product_id` = `products`.`id`";

                                $result_order_details = $connection->query($sql_order_details);

                                $sl_no = 1;
                                $total_amount = 0;

                                while($row_order_details = $result_order_details->fetch_assoc()){

                                    /** Product Name **/
                                    $sql_product_name = "SELECT * FROM `product_name` WHERE `pro_name_id`='$row_order_details[pro_name_id]'";

                                    if ($result_product_name = $connection->query($sql_product_name))
                                        $row_product_name = $result_product_name->fetch_assoc();

                                    /** Product Size Types **/
                                    $sql_size_types = "SELECT * FROM `size_types` WHERE `size_types_id`='$row_order_details[size_type_id]'";

                                    if ($result_size_types = $connection->query($sql_size_types))
                                        $row_size_types = $result_size_types->fetch_assoc();

                                    /** Product Sizes **/
                                    $sql_sizes = "SELECT * FROM `sizes` WHERE `size_id`='$row_order_details[size_id]'";

                                    if ($result_sizes = $connection->query($sql_sizes))
                                        $row_sizes = $result_sizes->fetch_assoc();

                                    /** Product Varient **/
                                    $sql_varient = "SELECT * FROM `varient` WHERE `varient_id`='$row_order_details[varient_id]'";

                                    if ($result_varient = $connection->query($sql_varient))
                                        $row_varient = $result_varient->fetch_assoc();

                                    /** Product Packing System **/
                                    $sql_quantity_in = "SELECT * FROM `quantity_in` WHERE `quantity_in_id`='$row_order_details[quantity_in_id]'";

                                    if ($result_quantity_in = $connection->query($sql_quantity_in))
                                        $row_quantity_in = $result_quantity_in->fetch_assoc();

                                    /** Product Print **/
                                    if($row_order_details['print'] == '1')
                                        $print = "Without Printing";
                                    else if($row_order_details['print'] == '3')
                                        $print = "Printing";
                                    else if($row_order_details['print'] == '4')
                                        $print = "With Printing";
                                    else
                                        $print = "NA";
                               ?> 
                              <tr>
                                <td><?php print $sl_no; ?></td>
                                <td><?php print $row_product_name['pro_name']; ?></td>
                                <td><?php print $row_size_types['size_types']; ?></td>
                                <td><?php print $row_sizes['size_name']; ?></td>
                                <td><?php print $row_varient['varient']; ?></td>
                                <td><?php print $print; ?></td>
                                <td><?php print $row_quantity_in['quantity_in']; ?></td>
                                <td><?php print $row_order_details['qty']; ?></td>
                                <td><?php print $row_order_details['standard_packing_in_piece']; ?>(in Single Qty)</td>
                                <td>
                                    <?php
                                    /** Actual Amount **/ 
                                    $actual_amount = ($row_order_details['order_price'] * $row_order_details['standard_packing_in_piece']);

                                    /** Sub-Total **/
                                    $subtotal = $actual_amount* $row_order_details['qty'];

                                    /** Total Amount Calculation **/
                                    $total_amount = $total_amount + $subtotal;

                                    print $subtotal;
                                    ?>
                                </td>
                              </tr>
                              <?php
                                    $sl_no++;
                                }
                              ?>
                            </tbody>
                          </table>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->

                      <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-xs-6">
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-6">
                          <div class="table-responsive">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <th style="width:50%">Subtotal:</th>
                                  <td>₹<?php print $total_amount; ?></td>
                                </tr>
                                <?php 
                                if (!empty($row_invoice['discount'])) {
                                    $discount = ($total_amount * $row_invoice['discount']) / 100;
                                    $total_amount = $total_amount - $discount;
                                ?>
                                <tr>
                                  <th style="width:50%">Discount:</th>
                                  <td>₹
                                    <?php print $discount; ?>
                                  </td>
                                </tr>
                                <?php
                                }

                                if ($row_invoice['payment_type'] == "Online") {
                                    $discount = ($total_amount * 2) / 100;
                                    $total_amount = $total_amount - $discount;
                                ?>
                                <tr>
                                  <th style="width:50%">Online Discount:</th>
                                  <td>₹
                                    <?php print $discount; ?>
                                  </td>
                                </tr>
                                <?php
                                }
                                ?>                              
                                <tr>
                                  <th>Total:</th>
                                  <td>₹<?php print $total_amount; ?></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                      </div>

                      <!-- this row will not appear when printing -->
                      <div class="row no-print">
                        <div class="col-xs-12">
                          <button class="btn btn-default" onclick="printDiv('printableArea')"><i class="fa fa-print"></i> Print</button>
                        </div>
                      </div>
                    </section>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

<?php

require_once "include/footer.php";
?>
<script>
function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    document.title = "Invoice";
    window.print();
    document.url = "";

    document.body.innerHTML = originalContents;
}
</script>