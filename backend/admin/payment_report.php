<?php

require_once "include/header.php";

if (!empty($_GET['user_id'])){

    $user_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['user_id']));
    $sql_user = "SELECT * FROM `user` WHERE `id`='$user_id'";

    if ($result_user = $connection->query($sql_user))
        $row_user = $result_user->fetch_assoc();

    /** Latest Remaining Balance **/
    $sql_payment_report = "SELECT * FROM `payment_report` WHERE `user_id`='$user_id' ORDER BY `id` DESC";
    if ($result_payment_report = $connection->query($sql_payment_report))
        $row_payment_report = $result_payment_report->fetch_assoc();
}

//Start of SQL Injection Function 
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function
?>     

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Payment Report</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"><br />
                <?php
                if (isset($_GET['msg'])) {
                    $msg = $_GET['msg'];
                    
                    if ($msg == 1){
                ?>
                <div class="alert alert-primary" role="alert">
                    Fields are empty.
                </div>
                <?php
                    }
                    if ($msg == 2){
                ?>
                <div class="alert alert-primary" role="alert">
                    Something wrong in the server.
                </div>
                <?php
                    }
                    if ($msg == 3){
                ?>
                <div class="alert alert-success" role="alert">
                    Report has been added.
                </div>
                <?php
                    }
                }
                ?>
                <!-- Section For New User registration -->
                <form method="POST" autocomplete="off" action="php/payment_report.php" class="form-horizontal form-label-left" enctype="multipart/form-data">
                    <?php
                    print "<b>".$row_user['name']."</b> : ";
                    print "Outstanding Balance : ";

                    if (!empty($row_payment_report['balance']))
                        print "₹ $row_payment_report[balance]";
                    else
                        print "0";
                    ?>
                    <input type="hidden" name="user_id" value="<?php print $user_id; ?>" required>
                    <div class="well" style="overflow: auto">
                        <div class="form-row mb-3">
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="total_amount">Order Value</label>
                                <input type="text" name="order_value" class="form-control" placeholder="Enter Order Value">
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="payment_recived">Payment Recived</label>
                                <input type="text" name="payment_recieved" class="form-control" placeholder="Enter Payment Recived">
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="date">Date</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="upload_file">Upload File</label>
                                <input type="file" name="upload_file[]" class="form-control" multiple>
                                (You can upload multiple file)
                            </div>
                        </div>
                    </div>

                  <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" name="submit" class="btn btn-success">Add Report</button>
                        <a class="btn btn-warning" onclick="window.close();">Close</a>
                      </div>
                    </div>
                </form>
                <!-- End New User registration -->
                </div>
              </div>
            </div>
        </div>
</div>
<?php
require_once "include/footer.php";
?>