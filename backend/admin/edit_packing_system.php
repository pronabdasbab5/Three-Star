<?php

require_once "include/header.php";

if (!empty($_GET['quantity_in_id'])){

    $quantity_in_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['quantity_in_id']));
    $sql_quantity_in = "SELECT * FROM `quantity_in` WHERE `quantity_in_id`='$quantity_in_id'";

    if ($result_quantity_in = $connection->query($sql_quantity_in))
        $row_quantity_in = $result_quantity_in->fetch_assoc();
}

//User Registration
if(isset($_POST['submit'])){

    if (!empty($_POST['quantity_in'])) {
        
        $quantity_in = ucwords($connection->real_escape_string(mysql_entities_fix_string($_POST['quantity_in'])));

        $quantity_in_update_sql = "UPDATE `quantity_in` SET `quantity_in`='$quantity_in' WHERE `quantity_in_id`='$quantity_in_id'";

        if($connection->query($quantity_in_update_sql))
            print "<script>window.location.href='all_packing_system.php'</script>";
        else
            showMessage(3); 
    } else
        showMessage(1);   
}
//End of User Registration

//Start of Messsage Checking Function
function showMessage($msg) {
    if ($msg == 1)
        print "<script>Swal.fire('Warning', 'Please ! Enter Packing System', 'question')</script>";
    if ($msg == 2)
        print "<script>Swal.fire({position: 'top-end', type: 'success', title: 'Packing System has been added successfully', showConfirmButton: false, timer: 1500})</script>";
    if ($msg == 3)
        print "<script>Swal.fire('Danger', 'Something wrong while adding.', 'question')</script>";
    if ($msg == 4)
        print "<script>Swal.fire('Info', 'Packing System already added.')</script>";
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
                <h2>Edit Packing System</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"><br />
                <!-- Section For New User registration -->
                <form method="POST" autocomplete="off" class="form-horizontal form-label-left">
                    <div class="well" style="overflow: auto">
                        <div class="form-row mb-3">
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                <label for="quantity_in">Packing System</label>
                                <input type="text" name="quantity_in" class="form-control" placeholder="Enter Packing System" value="<?php print $row_quantity_in['quantity_in']; ?>" required>
                            </div>
                        </div>
                    </div>

                  <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" name="submit" class="btn btn-success">Save Packing System</button>
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