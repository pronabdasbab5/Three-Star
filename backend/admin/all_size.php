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
                    <h2>All Size</h2>
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
                            <th>Size Type</th>
                            <th>Size</th>
                            <th>Add Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql_size = "SELECT * FROM `sizes` ORDER BY `size_id` DESC";

                        if ($result_size = $connection->query($sql_size)){

                            $slno = 0;

                            while($row_size = $result_size->fetch_assoc()) {

                                $slno++;

                                $sql_size_type = "SELECT * FROM `size_types` WHERE `size_types_id`='$row_size[size_types_id]'";

                                if ($result_size_type = $connection->query($sql_size_type))
                                    $row_size_type = $result_size_type->fetch_assoc();

                                if($row_size['status'] == 1)
                                    $status = "In-Active";
                                else
                                    $status = "Active";

                                print "<tr>";
                                print "<td>$slno</td>";
                                print "<td>$row_size_type[size_types]</td>";
                                print "<td>$row_size[size_name]</td>";
                                print "<td>$row_size[created_at]</td>";
                                print "<td><a href=\"status/size_status.php?size_id=$row_size[size_id]\" class=\"btn btn-primary\">$status</a></td>";
                                print "<td><a href=\"edit_size.php?size_id=$row_size[size_id]\" class=\"btn btn-warning\">Edit</a></td>";
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

