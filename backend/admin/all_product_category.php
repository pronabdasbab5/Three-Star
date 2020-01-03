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
                    <h2>All Product<small>Category</small></h2>
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
                            <th>Add Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql_pro_cate = "SELECT * FROM `product_category` ORDER BY `pro_cate_id` DESC";

                        if ($result_pro_cate = $connection->query($sql_pro_cate)){

                            $slno = 0;

                            while($row_pro_cate = $result_pro_cate->fetch_assoc()) {

                                $slno++;

                                if($row_pro_cate['status'] == 1)
                                    $status = "In-Active";
                                else
                                    $status = "Active";

                                print "<tr>";
                                print "<td>$slno</td>";
                                print "<td>$row_pro_cate[pro_cate_name]</td>";
                                print "<td>$row_pro_cate[created_at]</td>";
                                print "<td><a href=\"status/pro_cate_status.php?pro_cate_id=$row_pro_cate[pro_cate_id]\" class=\"btn btn-primary\">$status</a></td>";
                                print "<td><a href=\"pro_cate_edit.php?pro_cate_id=$row_pro_cate[pro_cate_id]\" class=\"btn btn-info\" target=\"_blank\" >Edit</a></td>";
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

