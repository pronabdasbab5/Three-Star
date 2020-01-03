<?php

require_once "include/header.php";

?>
<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>All Product<small>Name</small></h2>
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
                            <th>Category</th>
                            <th>Product Name</th>
                            <th>Add Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql_pro_name = "SELECT * FROM `product_name` ORDER BY `pro_name_id` DESC";

                        if ($result_pro_name = $connection->query($sql_pro_name)){

                            $slno = 0;
                            while($row_pro_name = $result_pro_name->fetch_assoc()) {

                                $slno++;
                                $sql_pro_cate = "SELECT * FROM `product_category` WHERE `pro_cate_id`='$row_pro_name[pro_cate_id]'";

                                if ($result_pro_cate = $connection->query($sql_pro_cate))
                                    $row_pro_cate = $result_pro_cate->fetch_assoc();

                                if($row_pro_name['status'] == 1)
                                    $status = "In-Active";
                                else
                                    $status = "Active";

                                print "<tr>";
                                print "<td>$slno</td>";
                                print "<td>$row_pro_cate[pro_cate_name]</td>";
                                print "<td>$row_pro_name[pro_name]</td>";
                                print "<td>$row_pro_name[created_at]</td>";
                                print "<td><a href=\"status/pro_name_status.php?pro_name_id=$row_pro_name[pro_name_id]\" class=\"btn btn-primary\">$status</a></td>";
                                print "<td><a href=\"pro_name_edit.php?pro_name_id=$row_pro_name[pro_name_id]\" style=\"text_decoration:none;\" target=\"_blank\" class=\"btn btn-warning\">Edit</a><a href=\"product_name_all_slider_image.php?product_name_id=$row_pro_name[pro_name_id]\" style=\"text_decoration:none;\" class=\"btn btn-danger\" target=\"_blank\">Slider Image</a><a href=\"make_product.blade.php?best_seller_product_id=$row_pro_name[pro_name_id]\" style=\"text_decoration:none;\" class=\"btn btn-info\">Make Best Seller Product</a></td>";
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

