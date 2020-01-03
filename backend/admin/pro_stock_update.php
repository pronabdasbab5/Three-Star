<?php

require_once "include/header.php";

if (!empty($_GET['product_id'])){

    $product_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['product_id']));

    $sql_product = "SELECT * FROM `products` WHERE `id`='$product_id'";

    if ($result_product = $connection->query($sql_product))
        $row_product = $result_product->fetch_assoc();
}

if (isset($_POST['add_stock'])) {

    $stock_update = $connection->real_escape_string(mysql_entities_fix_string($_POST['stock_update']));

    if (!empty($stock_update)) {
        
        $product_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['product_id']));

        $sql_stock_update = "UPDATE `products` SET `stock`=`stock`+'$stock_update' WHERE `id`='$product_id'";

        if ($connection->query($sql_stock_update))
            print "<script>window.close();window.opener.location.href = window.opener.location.href;</script>";
    }
    else
        showMessage(1);
}

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
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="clearfix"></div>

            <div class="row">
            	<div class="col-md-1 col-sm-1 col-xs-12">
            	</div>
              <div class="col-md-10 col-sm-10 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Product Information</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-hover" id="printTable">
                      <thead>
                        <tr>
                          <th>Fields</th>
                          <th>Information</th>
                        </tr>
                      </thead>
                      <tbody>
                      	<tr>
                          <th scope="row">Product Category</th>
                          <td>
                            <?php 

                                $sql_product_category = "SELECT * FROM `product_category` WHERE `pro_cate_id`='$row_product[pro_cate_id]'";

                                if ($result_product_category = $connection->query($sql_product_category))
                                    $row_product_category = $result_product_category->fetch_assoc();

                                print $row_product_category['pro_cate_name']; 
                            ?>
                            </td>
                        </tr>
                        <tr>
                          <th scope="row">Product Name</th>
                          <td>
                            <?php 

                            $sql_product_name = "SELECT * FROM `product_name` WHERE `pro_name_id`='$row_product[pro_name_id]'";

                            if ($result_product_name = $connection->query($sql_product_name))
                                $row_product_name = $result_product_name->fetch_assoc();

                            print $row_product_name['pro_name']; 
                            ?>
                            </td>
                        </tr>
                        <tr>
                          <th scope="row">Product Description</th>
                          <td><?php print $row_product['pro_desc']; ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Size Types</th>
                          <td>
                            <?php 

                            $sql_size_types = "SELECT * FROM `size_types` WHERE `size_types_id`='$row_product[size_type_id]'";

                            if ($result_size_types = $connection->query($sql_size_types))
                                $row_size_types = $result_size_types->fetch_assoc();

                            print $row_size_types['size_types']; 
                            ?>
                            </td>
                        </tr>
                        <tr>
                          <th scope="row">Sizes</th>
                          <td>
                            <?php 

                            $sql_sizes = "SELECT * FROM `sizes` WHERE `size_id`='$row_product[size_id]'";

                            if ($result_sizes = $connection->query($sql_sizes))
                                 $row_sizes = $result_sizes->fetch_assoc();

                            print $row_sizes['size_name']; 
                            ?> 
                            </td>
                        </tr>
                        <tr>
                          <th scope="row">Varient</th>
                          <td>
                            <?php 

                            $sql_varient = "SELECT * FROM `varient` WHERE `varient_id`='$row_product[varient_id]'";

                            if ($result_varient = $connection->query($sql_varient))
                                $row_varient = $result_varient->fetch_assoc();

                            print $row_varient['varient'];
                            ?>
                            </td>
                        </tr>
                        <tr>
                          <th scope="row">Print </th>
                          <td>
                            <?php 

                            if($row_product['print'] == 'printing')
                                $print = "Printing";
                            else if($row_product['print'] == 'with_printing')
                                $print = "Without Printing";
                            else
                                $print = "NA";

                            print $print; 
                            ?>
                            </td>
                        </tr>
                        <tr>
                          <th scope="row">Packing System</th>
                          <td>
                            <?php 

                            $sql_quantity_in = "SELECT * FROM `quantity_in` WHERE `quantity_in_id`='$row_product[quantity_in_id]'";

                            if ($result_quantity_in = $connection->query($sql_quantity_in))
                                $row_quantity_in = $result_quantity_in->fetch_assoc();

                            print $row_quantity_in['quantity_in']; 
                            ?>
                            </td>
                        </tr>
                        <tr>
                          <th scope="row">Standard Packing in Piece</th>
                          <td><?php print $row_product['standard_packing_in_piece']; ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Per Piece Price</th>
                          <td><?php print $row_product['per_piece_price']; ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Stock</th>
                          <td><?php print $row_product['stock']; ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Update Stock</th>
                          <td>
                            <form method="POST" autocomplete="off">
                                <input type="number" min="1" name="stock_update" style="border-radius: 5px;" placeholder="Enter Stock">
                                <button name="add_stock" type="submit" style="color: blue; border-radius: 5px;">Update</button>
                            </form>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <button type="button" class="btn btn-primary" id="prntBtn">Print Report</button>
                    <button type="button" class="btn btn-denger" id="winClose">Window Close</button>
                  </div>
                </div>
              </div>
              <div class="col-md-1 col-sm-1 col-xs-12">
            	</div>
            </div>
          </div>
        </div>
        <!-- /page content -->
<?php

require_once "include/footer.php";
?>
<script type="text/javascript">
$(document).ready(function(){
    $('#prntBtn').click(function(){
        window.print();
    });
    $('#winClose').click(function(){
        window.close();
    });
});
</script>