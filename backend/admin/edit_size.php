<?php

require_once "include/header.php";

if (!empty($_GET['size_id'])){

    $size_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['size_id']));

    $sql_size = "SELECT * FROM `sizes` WHERE `size_id`='$size_id'";

    if ($result_size = $connection->query($sql_size))
        $row_size = $result_size->fetch_assoc();
}

//User Registration
if(isset($_POST['submit'])){

    if (!empty($_POST['size'])) {
        
        $size = ucwords($connection->real_escape_string(mysql_entities_fix_string($_POST['size'])));

        $size_update_sql = "UPDATE `sizes` SET `size_name`='$size' WHERE `size_id`='$size_id'";
        if($connection->query($size_update_sql))
            print "<script>window.location.href='all_size.php'</script>";
        else
            showMessage(3);
    } else
        showMessage(1);   
}
//End of User Registration

//Start of Messsage Checking Function
function showMessage($msg) {
    if ($msg == 1)
        print "<script>Swal.fire('Warning', 'Please ! Enter required fields', 'question')</script>";
    if ($msg == 2)
        print "<script>Swal.fire({position: 'top-end', type: 'success', title: 'Size has been updated successfully', showConfirmButton: false, timer: 1500})</script>";
    if ($msg == 3)
        print "<script>Swal.fire('Danger', 'Something wrong while adding.', 'question')</script>";
    if ($msg == 4)
        print "<script>Swal.fire('Info', 'Size already added.')</script>";
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
                <h2>Edit Size</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"><br />
                <!-- Section For New User registration -->
                <form method="POST" autocomplete="off" class="form-horizontal form-label-left">

                    <div class="well" style="overflow: auto">
                        <div class="form-row mb-3">
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="size_type_id">Size Type</label>
                                <select name="size_type_id" class="form-control" required  disabled>
                                    <?php
                                    $retrive_size_type_sql = "SELECT * FROM `size_types` ORDER BY `size_types_id` ASC";

                                    if ($result_size_type = $connection->query($retrive_size_type_sql)) 
                                        while ($row_size_type = $result_size_type->fetch_assoc()){
                                            if ($row_size_type['size_types_id'] == $row_size['size_types_id'])
                                                print "<option value=\"$row_size_type[size_types_id]\" selected>$row_size_type[size_types]</option>";
                                            else
                                                print "<option value=\"$row_size_type[size_types_id]\">$row_size_type[size_types]</option>";
                                        }
                                    ?>
                                  </select>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="size">Size</label>
                                <input type="text" name="size" class="form-control" placeholder="Enter Size" value="<?php print $row_size                            ['size_name']; ?>" required>
                            </div>
                        </div>
                    </div>

                  <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" name="submit" class="btn btn-success">Save Size</button>
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