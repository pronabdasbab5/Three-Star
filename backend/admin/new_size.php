<?php

require_once "include/header.php";

//User Registration
if(isset($_POST['submit'])){

    if (!empty($_POST['size_type_id']) && !empty($_POST['size'])) {
        
        $size_type_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['size_type_id']));
        $size = ucwords($connection->real_escape_string(mysql_entities_fix_string($_POST['size'])));

        $sizes_count_sql = "SELECT * FROM `sizes` WHERE `size_name`='$size' and `size_types_id`='$size_type_id'";

        if ($sizes_count = $connection->query($sizes_count_sql)) {

            if($sizes_count->num_rows == 0) {

                $current_date = date('d-m-Y');

                $sizes_add_sql = "INSERT INTO `sizes` (`size_types_id`, `size_name`, `created_at`) VALUES ('$size_type_id', '$size', '$current_date')";

                if($connection->query($sizes_add_sql))
                    showMessage(2);
                else
                    showMessage(3);
            } else
                showMessage(4);   
        } else
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
        print "<script>Swal.fire({position: 'top-end', type: 'success', title: 'Size has been added successfully', showConfirmButton: false, timer: 1500})</script>";
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
                <h2>New Size</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"><br />
                <!-- Section For New User registration -->
                <form method="POST" autocomplete="off" class="form-horizontal form-label-left">

                    <div class="well" style="overflow: auto">
                        <div class="form-row mb-3">
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="size_type_id">Size Type</label>
                                <select name="size_type_id" class="form-control" required>
                                    <option selected disabled>Choose Size Type</option>
                                    <?php
                                    $retrive_size_type_sql = "SELECT * FROM `size_types` WHERE `status`='1' ORDER BY `size_types_id` ASC";

                                    if ($result_size_type = $connection->query($retrive_size_type_sql)) 
                                        while ($row_size_type = $result_size_type->fetch_assoc())
                                            print "<option value=\"$row_size_type[size_types_id]\">$row_size_type[size_types]</option>";
                                    ?>
                                  </select>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="size">Size</label>
                                <input type="text" name="size" class="form-control" placeholder="Enter Size" required>
                            </div>
                        </div>
                    </div>

                  <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" name="submit" class="btn btn-success">Add Size</button>
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