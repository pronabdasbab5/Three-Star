<?php

require_once "include/header.php";

//User Registration
if(isset($_POST['submit'])){

    if (!empty($_POST['pro_cate'])) {
        
        $pro_cate = ucwords(strtolower($connection->real_escape_string(mysql_entities_fix_string($_POST['pro_cate']))));

        $pro_cate_count_sql = "SELECT * FROM `product_category` WHERE `pro_cate_name`='$pro_cate'";

        if ($pro_cate_count = $connection->query($pro_cate_count_sql)) {

            if($pro_cate_count->num_rows == 0) {

                $pro_cate_count_sql_1 = "SELECT * FROM `product_category`";

                if ($pro_cate_count_1 = $connection->query($pro_cate_count_sql_1)) {

                    $current_date = date('d-m-Y');

                    $pro_cate_add_sql = "INSERT INTO `product_category` (`pro_cate_name`, `created_at`) VALUES ('$pro_cate', '$current_date')";

                    if($connection->query($pro_cate_add_sql))
                        showMessage(2);
                    else
                        showMessage(3);
                } else
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
        print "<script>Swal.fire('Warning', 'Please ! Enter Category', 'question')</script>";
    if ($msg == 2)
        print "<script>Swal.fire({position: 'top-end', type: 'success', title: 'Category has been added successfully', showConfirmButton: false, timer: 1500})</script>";
    if ($msg == 3)
        print "<script>Swal.fire('Danger', 'Something wrong while adding.', 'question')</script>";
    if ($msg == 4)
        print "<script>Swal.fire('Info', 'Category already added.')</script>";
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
                <h2>New Product Category</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"><br />
                <!-- Section For New User registration -->
                <form method="POST" autocomplete="off" class="form-horizontal form-label-left">
                  <div class="well" style="overflow: auto">
                    <div class="form-row mb-3">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-3">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" name="pro_cate"  placeholder="Enter Category" required>
                        </div>
                    </div>
                </div>

                  <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" name="submit" class="btn btn-success">Add Category</button>
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