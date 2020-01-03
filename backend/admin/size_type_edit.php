<?php

require_once "include/header.php";

if (!empty($_GET['size_type_id'])){

    $size_type_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['size_type_id']));

    $sql_size_type = "SELECT * FROM `size_types` WHERE `size_types_id`='$size_type_id'";

    if ($result_size_type = $connection->query($sql_size_type))
        $row_size_type = $result_size_type->fetch_assoc();
}

//User Registration
if(isset($_POST['submit'])){

    if (!empty($_POST['size_type'])) {
        
        $size_type = ucwords($connection->real_escape_string(mysql_entities_fix_string($_POST['size_type'])));
        
        if ($size_type != $row_size_type['size_types']) {
            
            $size_type_count_sql = "SELECT * FROM `size_types` WHERE `size_types`='$size_type'";

            if ($size_type_count = $connection->query($size_type_count_sql)) {

                if ($size_type_count->num_rows == 0) {

                    $size_type_update_sql ="UPDATE `size_types` SET `size_types`='$size_type' WHERE `size_types_id`='$size_type_id'";

                    if ($connection->query($size_type_update_sql))
                        print "<script>window.location.href='all_size_type.php';</script>";
                    else
                        showMessage(3);
                } else
                    showMessage(4);
            } else
                showMessage(3);
        } else
            print "<script>window.close();window.opener.location.href = window.opener.location.href;</script>"; 
    } else
        showMessage(1);   
}
//End of User Registration

//Start of Messsage Checking Function
function showMessage($msg) {
    if ($msg == 1)
        print "<script>Swal.fire('Warning', 'Please ! Enter Size Type', 'question')</script>";
    if ($msg == 3)
        print "<script>Swal.fire('Danger', 'Something wrong while updating.', 'question')</script>";
    if ($msg == 4)
        print "<script>Swal.fire('Info', 'Size Type already available.')</script>";
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
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Edit Size Type</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            <!-- Section For New User registration -->
                <form method="POST" autocomplete="off" class="form-horizontal form-label-left">
                  <div class="well" style="overflow: auto">
                        <div class="form-row mb-3">
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                <label for="size_type">Size Type</label>
                                <input type="text" name="size_type" class="form-control col-md-7 col-xs-12" placeholder="Enter Size Type" value="<?php print $row_size_type['size_types']; ?>" required>
                            </div>
                        </div>
                    </div>

                  <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" name="submit" class="btn btn-success">Save Size Type</button>
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