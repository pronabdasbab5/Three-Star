<?php

require_once "include/header.php";

if (!empty($_GET['user_id'])){

    $user_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['user_id']));
    $sql_user = "SELECT `payment_report`.*, `user`.`name` FROM `user`, `payment_report` WHERE `payment_report`.`user_id` = `user`.`id` AND `user`.`id` = '$user_id' AND `payment_report`.`user_id`='$user_id'";

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
                    <h2><?php print $row_user['name']; ?> Payment History</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					<center>
                        <form method="POST" autocomplete="off">
                            From: <input type="date" name="from_date" required>
                            To: <input type="date" name="to_date" required>
                            <button type="submit" name="submit">Search</button> 
                        </form>              
                    </center>
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Date</th>
                            <th>Order (Dr)</th>
                            <th>Recived (Cr)</th>
                            <th>Balance</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $where = "";
                        if (isset($_POST['submit'])) {
                            $from_date = $connection->real_escape_string(mysql_entities_fix_string($_POST['from_date']));
                            $to_date = $connection->real_escape_string(mysql_entities_fix_string($_POST['to_date']));

                            $where = "AND `date` >= '$from_date' AND `date` <= '$to_date'";
                        }

                        $sql_payment_report = "SELECT * FROM `payment_report` WHERE `user_id`='$user_id' $where ORDER BY `id` ASC";

                        if ($result_payment_report = $connection->query($sql_payment_report)){

                            $slno = 0;
                            while($row_payment_report = $result_payment_report->fetch_assoc()) {

                                $slno++;
                                print "<tr>";
                                print "<td>$slno</td>";
                                print "<td>$row_payment_report[date]</td>";
                                print "<td>$row_payment_report[order_value]</td>";
                                print "<td>$row_payment_report[payment_recieve]</td>";
                                print "<td>$row_payment_report[balance]</td>";
                                print "</tr>";
                            }
                        }
                        ?>
                      </tbody>
                    </table>
                    <button class="btn btn-default" onclick="exportTableToExcel('datatable-responsive', 'payment-history')">Export</button>
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
<script type="text/javascript">
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script>


