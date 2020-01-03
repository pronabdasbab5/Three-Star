<?php

require_once "include/header.php";

if (!empty($_GET['user_id'])){

    $user_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['user_id']));
    $sql_user = "SELECT `user`.`name` FROM `user` WHERE `id` = '$user_id'";

    if ($result_user = $connection->query($sql_user))
        $row_user = $result_user->fetch_assoc();
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
<div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php print $row_user['name']; ?> Payment Reports</h2>
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
                            <th>Date</th>
                            <th>Download File</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql_payment_report = "SELECT * FROM `payment_report` WHERE `user_id` = '$user_id' ORDER BY `id` DESC";

                        if ($result_payment_report = $connection->query($sql_payment_report)){

                            $slno = 0;
                            while($row_payment_report = $result_payment_report->fetch_assoc()) {
                                $slno++;

                                $sql_payment_report_file = "SELECT * FROM `payment_report_file` WHERE `payment_report_id`='$row_payment_report[id]' ORDER BY `id` DESC";

                                $result_payment_report_file = $connection->query($sql_payment_report_file);

                                if ($result_payment_report_file->num_rows > 0) {

                                    $download_file = "";
                                    $slno_1 = 0;

                                    while($row_payment_report_file = $result_payment_report_file->fetch_assoc()){

                                        $slno_1++;
                                        $download_file = $download_file."<a href=\"php/download.php?file=".urlencode($row_payment_report_file['file'])."\" class=\"btn btn-primary\">Download File $slno_1</a>";
                                    }

                                    print "<tr>";
                                    print "<td>$slno</td>";
                                    print "<td>$row_payment_report[date]</td>";
                                    print "<td>$download_file</td>";
                                    print "</tr>";
                                }
                            }
                        }
                        ?>
                      </tbody>
                    </table>
                    <button class="btn btn-warning" onclick="window.close();">Close</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<?php

require_once "include/footer.php";
?>


