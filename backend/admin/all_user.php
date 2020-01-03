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
                    <h2>All Users</h2>
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
                            <th>Name</th>
                            <th>Name of Firm</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <th>Discount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                        $sql_user = "SELECT * FROM `user` ORDER BY `id` DESC";

                        if ($result_user = $connection->query($sql_user)){

                            $slno = 0;

                            while($row_user = $result_user->fetch_assoc()) {

                                $slno++;

                                if($row_user['status'] == 1){
                                    $status = "<td><a class=\"btn btn-success\">Active</a></td>";
                                    $update_status = "<a href=\"status/user_status.php?user_id=$row_user[id]\" style=\"text_decoration:none;\" class=\"btn btn-warning\">In-Active</a>";
                                }
                                else{
                                   $status = "<td><a class=\"btn btn-success\">In-Active</a></td>"; 
                                   $update_status = "<a href=\"status/user_status.php?user_id=$row_user[id]\" style=\"text_decoration:none;\" class=\"btn btn-warning\">Active</a>";
                                }

                                print "<tr>";
                                print "<td>$slno</td>";
                                print "<td>$row_user[name_of_firm]</td>";
                                print "<td>$row_user[name]</td>";
                                print "<td>$row_user[email]</td>";
                                print "<td>$row_user[contact_no]</td>";
                                print "<td>$row_user[discount]</td>";
                                print "$status";
                                print "<td>$update_status<a href=\"user_detail.php?user_id=$row_user[id]\" class=\"btn btn-primary\" target=\"_blank\">View</a><a href=\"user_info_edit.php?user_id=$row_user[id]\" class=\"btn btn-danger\" target=\"_blank\">Edit</a><a href=\"payment_report.php?user_id=$row_user[id]\" class=\"btn btn-primary\" target=\"_blank\">Payment Report</a><a href=\"payment_history.php?user_id=$row_user[id]\" class=\"btn btn-warning\" target=\"_blank\">Payment History</a><a href=\"payment_report_file_list.php?user_id=$row_user[id]\" class=\"btn btn-info\" target=\"_blank\">Download Reports</a></td>";
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


