<?php

require_once "include/header.php";

if (!empty($_GET['pro_cate_id'])){

    $pro_cate_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['pro_cate_id']));

    $sql_pro_cate = "SELECT * FROM `product_category` WHERE `pro_cate_id`='$pro_cate_id'";

    if ($result_pro_cate = $connection->query($sql_pro_cate))
        $row_pro_cate = $result_pro_cate->fetch_assoc();
}

//User Registration
if(isset($_POST['submit'])){

    if (!empty($_POST['pro_cate'])) {
        
        $pro_cate = ucwords(strtolower($connection->real_escape_string(mysql_entities_fix_string($_POST['pro_cate']))));
        
        if ($pro_cate != $row_pro_cate['pro_cate_name']) {
            
            $pro_cate_count_sql = "SELECT * FROM `product_category` WHERE `pro_cate_name`='$pro_cate'";

            if ($pro_cate_count = $connection->query($pro_cate_count_sql)) {

                if ($pro_cate_count->num_rows == 0) {

                    $pro_cate_update_sql ="UPDATE `product_category` SET `pro_cate_name`='$pro_cate' WHERE `pro_cate_id`='$pro_cate_id'";

                    if ($connection->query($pro_cate_update_sql))
                        print "<script>window.close();window.opener.location.href = window.opener.location.href;</script>";
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
        print "<script>Swal.fire('Warning', 'Please ! Enter Category', 'question')</script>";
    if ($msg == 3)
        print "<script>Swal.fire('Danger', 'Something wrong while updating.', 'question')</script>";
    if ($msg == 4)
        print "<script>Swal.fire('Info', 'Category already available.')</script>";
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
            <h2>Edit Product Category</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            <!-- Section For New User registration -->
                <form method="POST" autocomplete="off" class="form-horizontal form-label-left">
                    <div class="well" style="overflow: auto">
                        <div class="form-row mb-3">
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                                <label for="category">Category</label>
                                <input type="text" name="pro_cate" class="form-control col-md-7 col-xs-12" placeholder="Enter Category" value="<?php print $row_pro_cate['pro_cate_name']; ?>" required>
                            </div>
                        </div>
                    </div>

                  <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" name="submit" class="btn btn-success">Save</button>
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