<?php

require_once "include/header.php";

if (!empty($_GET['user_id'])){

    $user_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['user_id']));
    $sql_user = "SELECT * FROM `user` WHERE `id`='$user_id'";

    if ($result_user = $connection->query($sql_user))
        $row_user = $result_user->fetch_assoc();
}

//User Registration
if(isset($_POST['submit'])){

    if (!empty($_POST['name']) && !empty($_POST['contact_no']) && !empty($_POST['old_contact_no']) && !empty($_POST['address'])) {
        
        $name = ucwords($connection->real_escape_string(mysql_entities_fix_string($_POST['name'])));
        $contact_no = $connection->real_escape_string(mysql_entities_fix_string($_POST['contact_no']));
        $old_contact_no = $connection->real_escape_string(mysql_entities_fix_string($_POST['old_contact_no']));
        $address = $connection->real_escape_string(mysql_entities_fix_string($_POST['address']));

         if (!empty($_POST['co_firm_name']))
            $firm_name = $connection->real_escape_string(mysql_entities_fix_string($_POST['co_firm_name']));
        else
            $firm_name = "";

        if (!empty($_POST['alter_no']))
            $alter_no = $connection->real_escape_string(mysql_entities_fix_string($_POST['alter_no']));
        else
            $alter_no = "";

        if (!empty($_POST['email']))
            $email = $connection->real_escape_string(mysql_entities_fix_string($_POST['email']));
        else
            $email = "";

        if (!empty($_POST['gst_no']))
            $gst_no = $connection->real_escape_string(mysql_entities_fix_string($_POST['gst_no']));
        else
            $gst_no = "";

        if (!empty($_POST['discount']))
            $discount = $connection->real_escape_string(mysql_entities_fix_string($_POST['discount']));
        else
            $discount = "";

        $user_update_sql = "UPDATE `user` SET `name_of_firm`='$firm_name', `name`='$name', `email`='$email', `gst_no`='$gst_no', `address`='$address', `alter_no`='$alter_no', `discount` = '$discount' WHERE `id`='$user_id'";

            if($connection->query($user_update_sql))
                print "<script>window.close();</script>";
            else
                $msg = 2;
    } else
        $msg = 1;  
}
//End of User Registration

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
                <h2>Edit User</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"><br />
                <?php
                if (isset($_GET['msg'])) {
                    $msg = $_GET['msg'];
                    
                    if ($msg == 1)
                ?>
                <div class="alert alert-primary" role="alert">
                    Fields are empty.
                </div>
                <?php
                    if ($msg == 2)
                ?>
                <div class="alert alert-primary" role="alert">
                    Something wrong in the server.
                </div>
                <?php
                }
                ?>
                <!-- Section For New User registration -->
                <form method="POST" autocomplete="off" class="form-horizontal form-label-left">
                  <div class="well" style="overflow: auto">
                        <div class="form-row mb-3">
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter Name" value="<?php print $row_user['name']; ?>" required>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="email">Name of Firm</label>
                                <input type="text" name="co_firm_name" class="form-control" placeholder="Enter Name of Firm" value="<?php print $row_user['name_of_firm']; ?>">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="contact_no">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email." value="<?php print $row_user['email']; ?>">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="contact_no">Contact No.</label>
                                <input type="text" name="contact_no" class="form-control" placeholder="Enter Contact No." value="<?php print $row_user['contact_no']; ?>" required>
                                <input type="hidden" value="<?php print $row_user['contact_no']; ?>" name="old_contact_no" required>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="contact_no">GST No.</label>
                                <input type="text" name="gst_no" class="form-control" placeholder="Enter GST No." value="<?php print $row_user['gst_no']; ?>">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="contact_no">Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Enter Address" value="<?php print $row_user['address']; ?>" required>
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="contact_no">Alternative No.</label>
                                <input type="text" name="alter_no" class="form-control" placeholder="Enter Alternative No." value="<?php print $row_user['alter_no']; ?>">
                            </div>
                            <div class="col-md-4 col-sm-12 col-xs-12 mb-3">
                                <label for="contact_no">Discount</label>
                                <input type="number" name="discount" class="form-control" placeholder="Enter Discount" value="<?php print $row_user['discount']; ?>">
                            </div>
                        </div>
                    </div>

                  <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" name="submit" class="btn btn-success">Save User Info.</button>
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