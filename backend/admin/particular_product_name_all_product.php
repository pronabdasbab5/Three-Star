<?php

require_once "include/header.php";

//User Registration
if(isset($_POST['submit'])){

    if (!empty($_GET['pro_cate_id']) && !empty($_GET['pro_name_id'])) {
        
        $product_category_id   = ucwords($connection->real_escape_string(mysql_entities_fix_string($_POST['product_category_id'])));
        $product_name_id   = ucwords($connection->real_escape_string(mysql_entities_fix_string($_POST['product_name_id'])));

        print "<script>window.location.href='stock_update.php?product_category_id=$product_category_id&product_name_id=$product_name_id'</script>";
    } else
        showMessage(1);   
}
//End of User Registration

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
                    <h2>Product Info.</h2>
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
                            <th>Product Category</th>
                            <th>Product Name</th>
                            <th>Size Types</th>
                            <th>Sizes</th>
                            <th>Varient</th>
                            <th>Print</th>
                            <th>Status</th>
                            <th>Packing System</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (!empty($_GET['pro_cate_id']) && !empty($_GET['pro_name_id'])) {

                            $product_category_id   = ucwords($connection->real_escape_string(mysql_entities_fix_string($_GET['pro_cate_id'])));
                            $product_name_id   = ucwords($connection->real_escape_string(mysql_entities_fix_string($_GET['pro_name_id'])));
                            
                            $sql_pro_stock = "SELECT DISTINCT * FROM `products` WHERE `pro_cate_id`='$product_category_id' AND `pro_name_id`='$product_name_id' ORDER BY `id` DESC";

                            if ($result_pro_stock = $connection->query($sql_pro_stock)){

                                $slno = 0;
                                while($row_pro_stock = $result_pro_stock->fetch_assoc()) {

                                    $slno++;

                                    if($row_pro_stock['status'] == 1) {
                                        $status = "Active";
                                        $status_btn = "<a href=\"status/product_status.php?product_id=$row_pro_stock[id]\" class=\"btn btn-primary\" target=\"_blank\">Inactive</a>";
                                    }
                                    else {
                                        $status = "Inactive";
                                        $status_btn = "<a href=\"status/product_status.php?product_id=$row_pro_stock[id]\" class=\"btn btn-primary\" target=\"_blank\">Active</a>";
                                    }

                                    $sql_product_category = "SELECT * FROM `product_category` WHERE `pro_cate_id`='$product_category_id'";

                                    if ($result_product_category = $connection->query($sql_product_category))
                                        $row_product_category = $result_product_category->fetch_assoc();

                                    $sql_product_name = "SELECT * FROM `product_name` WHERE `pro_name_id`='$product_name_id'";

                                    if ($result_product_name = $connection->query($sql_product_name))
                                        $row_product_name = $result_product_name->fetch_assoc();

                                    $sql_size_types = "SELECT * FROM `size_types` WHERE `size_types_id`='$row_pro_stock[size_type_id]'";

                                    if ($result_size_types = $connection->query($sql_size_types))
                                        $row_size_types = $result_size_types->fetch_assoc();

                                    $sql_sizes = "SELECT * FROM `sizes` WHERE `size_id`='$row_pro_stock[size_id]'";

                                    if ($result_sizes = $connection->query($sql_sizes))
                                        $row_sizes = $result_sizes->fetch_assoc();

                                    $sql_varient = "SELECT * FROM `varient` WHERE `varient_id`='$row_pro_stock[varient_id]'";

                                    if ($result_varient = $connection->query($sql_varient))
                                        $row_varient = $result_varient->fetch_assoc();

                                    $sql_quantity_in = "SELECT * FROM `quantity_in` WHERE `quantity_in_id`='$row_pro_stock[quantity_in_id]'";

                                    if ($result_quantity_in = $connection->query($sql_quantity_in))
                                        $row_quantity_in = $result_quantity_in->fetch_assoc();

                                    if($row_pro_stock['print'] == '1')
                                        $print = "Without Printing";
                                    else if($row_pro_stock['print'] == '3')
                                        $print = "Printing";
                                    else if($row_pro_stock['print'] == '4')
                                        $print = "With Printing";
                                    else
                                        $print = "NA";

                                    print "<tr>";
                                    print "<td>$slno</td>";
                                    print "<td>$row_product_category[pro_cate_name]</td>";
                                    print "<td>$row_product_name[pro_name]</td>";
                                    print "<td>$row_size_types[size_types]</td>";
                                    print "<td>$row_sizes[size_name]</td>";
                                    print "<td>$row_varient[varient]</td>";
                                    print "<td>$print</td>";
                                    print "<td><a class=\"btn btn-success\">$status</a></td>";
                                    print "<td>$row_quantity_in[quantity_in]</td>";
                                    print "<td>$row_pro_stock[stock]</td>";
                                    print "<td>$status_btn<a href=\"product_edit.php?product_id=$row_pro_stock[id]\" style=\"text_decoration:none;\" target=\"_blank\" class=\"btn btn-warning\">Edit</a></td>";
                                    print "</tr>";
                                }
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
