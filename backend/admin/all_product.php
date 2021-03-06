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
                    <h2>All Products</h2>
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
                            <th>View Product</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                        $sql_pro_stock = "SELECT DISTINCT `pro_cate_id`, `pro_name_id` FROM `products` ORDER BY `id` DESC";

                        if ($result_pro_stock = $connection->query($sql_pro_stock)){

                            $slno = 0;

                            while($row_pro_stock = $result_pro_stock->fetch_assoc()) {

                                $slno++;

                                $sql_product_category = "SELECT * FROM `product_category` WHERE `pro_cate_id`='$row_pro_stock[pro_cate_id]'";

                                if ($result_product_category = $connection->query($sql_product_category))
                                    $row_product_category = $result_product_category->fetch_assoc();

                                $sql_product_name = "SELECT * FROM `product_name` WHERE `pro_name_id`='$row_pro_stock[pro_name_id]'";

                                if ($result_product_name = $connection->query($sql_product_name))
                                    $row_product_name = $result_product_name->fetch_assoc();

                                print "<tr>";
                                print "<td>$slno</td>";
                                print "<td>$row_product_category[pro_cate_name]</td>";
                                print "<td>$row_product_name[pro_name]</td>";
                                print "<td><a href=\"particular_product_name_all_product.php?pro_cate_id=$row_pro_stock[pro_cate_id]&pro_name_id=$row_pro_stock[pro_name_id]\" style=\"text_decoration:none;\" target=\"_blank\" class=\"btn btn-warning\">All Products</a></td>";
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


