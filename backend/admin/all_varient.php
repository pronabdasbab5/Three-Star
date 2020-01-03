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
                    <h2>All Varient</h2>
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
                            <th>Varient</th>
                            <th>Add Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql_varient = "SELECT * FROM `varient` ORDER BY `varient_id` DESC";
                        if ($result_varient = $connection->query($sql_varient)){

                            $slno = 0;
                            while($row_varient = $result_varient->fetch_assoc()) {

                                $slno++;
                                if($row_varient['status'] == 1)
                                    $status = "In-Active";
                                else
                                    $status = "Active";

                                print "<tr>";
                                print "<td>$slno</td>";
                                print "<td>$row_varient[varient]</td>";
                                print "<td>$row_varient[created_at]</td>";
                                print "<td><a href=\"status/varient_status.php?varient_id=$row_varient[varient_id]\" class=\"btn btn-primary\">$status</a></td>";
                                print "<td><a href=\"edit_varient.php?varient_id=$row_varient[varient_id]\" class=\"btn btn-warning\">Edit</a></td>";
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

