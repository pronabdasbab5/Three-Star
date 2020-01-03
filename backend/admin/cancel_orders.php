<?php

require_once "include/header.php";

//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function

//Start of Messsage Checking Function
function showMessage($msg) {
    if ($msg == 1)
        print "<script>Swal.fire('Warning', 'Please ! Enter required fields', 'question')</script>";
}
//End of Messsage Checking Function
?>
<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Cancel Orders</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Order ID</th>
                            <th>User Name</th>
                            <th>Contact No.</th>
                            <th>Total Amount</th>
                            <th>Payment Date</th>
                            <th>Payment Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php

                        $sql_orders = "SELECT `orders`.*, `user`.`name`, `user`.`contact_no` FROM `orders`, `user` WHERE `orders`.`user_id` = `user`.`id` AND `orders`.`status`=3 ORDER BY `orders`.`id` DESC";

                        if ($result_orders = $connection->query($sql_orders)){
                            $slno = 0;
                            while($row_orders = $result_orders->fetch_assoc()) {

                                $slno++;

                                if($row_orders['status'] == 3)
                                    $status = "<a class=\"btn btn-success\">Cancel Order</a>";

                                print "<tr>";
                                print "<td>$slno</td>";
                                print "<td>$row_orders[order_id]</td>";
                                print "<td>$row_orders[name]</td>";
                                print "<td>$row_orders[contact_no]</td>";
                                print "<td>$row_orders[total_amount]</td>";
                                print "<td>$row_orders[payment_date]</td>";
                                print "<td>$row_orders[payment_type]</td>";
                                print "<td>$status</td>";
                                print "<td><a href=\"status/accept_order.php?order_id=$row_orders[id]\" class=\"btn btn-primary\">Accept</a><a href=\"invoice.php?order_id=$row_orders[id]\" class=\"btn btn-danger\" target=\"_blank\">Details</a></td>";
                                print "</tr>";
                            }
                        }
                        ?> 
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<?php

require_once "include/footer.php";
?>


