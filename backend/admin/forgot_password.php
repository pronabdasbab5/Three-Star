<?php

require_once "include/header.php";

//User Registration
if(isset($_POST['submit'])){

    if (!empty($_POST['password']) && !empty($_POST['con_password'])) {
        
        $password   = $connection->real_escape_string(mysql_entities_fix_string($_POST['password']));
        $con_password   = $connection->real_escape_string(mysql_entities_fix_string($_POST['con_password']));

        if ($password == $con_password) {
            
            $update_user_sql = "UPDATE `admin` SET `password`='$password' WHERE `admin_id`='$_SESSION[admin_user_id]'";
            if($connection->query($update_user_sql))
                showMessage(3);
            else
                showMessage(4);
        }
        else
            showMessage(2);
    } else
        showMessage(1);   
}
//End of User Registration

//Start of Messsage Checking Function
function showMessage($msg) {
    if ($msg == 1)
        print "<script>Swal.fire('Warning', 'Please ! Enter required fields', 'question')</script>";
    if ($msg == 3)
        print "<script>Swal.fire({position: 'top-end', type: 'success', title: 'Password has been changed.', showConfirmButton: false, timer: 1500})</script>";
    if ($msg == 4)
        print "<script>Swal.fire('Danger', 'Something wrong while changing.', 'question')</script>";
    if ($msg == 2)
        print "<script>Swal.fire('Info', 'Password and Confirm Password are not same.')</script>";
}
//End of Messsage Checking Function

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
        <div class="col-md-1 col-sm-1 col-xs-12"></div>
      <div class="col-md-10 col-sm-10 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Forgot Pasword</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" class="form-horizontal form-label-left">
              <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-xs-12">Password : <span class="required">*</span></label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="password"  name="password"  class="form-control col-md-7 col-xs-12" placeholder="Enter Password" required>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-4 col-sm-4 col-xs-12">Confirm Password : <span class="required">*</span></label>
                <div class="col-md-8 col-sm-8 col-xs-12">
                  <input type="text"  name="con_password"  class="form-control col-md-7 col-xs-12" placeholder="Enter Confirm Password" required>
                </div>
              </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success">Save Password</button>
                  </div>
                </div>
            </form>
            <!-- End New User registration -->
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-1 col-sm-1 col-xs-12"></div>
</div>
<?php
require_once "include/footer.php";
?>