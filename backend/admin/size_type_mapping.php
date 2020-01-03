<?php

require_once "include/header.php";

//User Registration
if(isset($_POST['submit'])){

    if (!empty($_POST['category_id']) && !empty($_POST['size_types_id'])) {
        
        $category_id   = ucwords($connection->real_escape_string(mysql_entities_fix_string($_POST['category_id'])));
        $size_types_id   = ucwords($connection->real_escape_string(mysql_entities_fix_string($_POST['size_types_id'])));

        $category_size_mapping_count_sql = "SELECT * FROM `category_size_mapping` WHERE `category_id`='$category_id' AND `size_types_id`='$size_types_id'";

        if ($category_size_mapping_count = $connection->query($category_size_mapping_count_sql)) {

            if($category_size_mapping_count->num_rows == 0) {

                $category_size_mapping_add_sql = "INSERT INTO `category_size_mapping` (`category_id`, `size_types_id`) VALUES ('$category_id', '$size_types_id')";

                if($connection->query($category_size_mapping_add_sql))
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
    if ($msg == 2)
        print "<script>Swal.fire({position: 'top-end', type: 'success', title: 'Mapping has been added successfully', showConfirmButton: false, timer: 1500})</script>";
    if ($msg == 3)
        print "<script>Swal.fire('Danger', 'Something wrong while mapping.', 'question')</script>";
    if ($msg == 4)
        print "<script>Swal.fire('Info', 'Mapping already added.')</script>";
}
//End of Messsage Checking Function
?>
<div class="right_col" role="main">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Size Type Mapping</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content"><br />
            <!-- Section For New User registration -->
            <form method="POST" autocomplete="off" class="form-horizontal form-label-left">
              
                    <div class="well" style="overflow: auto">
                        <div class="form-row mb-3">
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control" required>
                                <option selected disabled>Choose Category</option>
                                <?php
                                $sql_pro_cate = "SELECT * FROM `product_category` WHERE `status`='1' ORDER BY `pro_cate_id` DESC";

                                if ($result_pro_cate = $connection->query($sql_pro_cate))
                                    while($row_pro_cate = $result_pro_cate->fetch_assoc())
                                        print "<option value=\"$row_pro_cate[pro_cate_id]\">$row_pro_cate[pro_cate_name]</option>";
                                ?>
                              </select>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="size_types_id">Size Type</label>
                                <select name="size_types_id" id="size_types_id" class="form-control" required>
                                <option selected disabled>Choose Size Type</option>
                                <?php
                                $sql_size_types = "SELECT * FROM `size_types` WHERE `status`='1' ORDER BY `size_types_id` DESC";

                                if ($result_size_types = $connection->query($sql_size_types))
                                    while($row_size_types = $result_size_types->fetch_assoc())
                                        print "<option value=\"$row_size_types[size_types_id]\">$row_size_types[size_types]</option>";
                                ?>
                              </select>
                            </div>
                        </div>
                    </div>

              <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-success">Add Mapping</button>
                  </div>
                </div>
            </form>
            <!-- End New User registration -->
            </div>
          </div>
        </div>
      </div>
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Product Info.</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
					
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Category</th>
                            <th>Size Types</th>
                            <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $sql_size_types_mapping = "SELECT DISTINCT `product_category`.`pro_cate_name` AS category, `size_types`.`size_types`, `category_size_mapping`.`id`, `category_size_mapping`.`status` FROM `category_size_mapping`, `product_category`, `size_types` WHERE `category_size_mapping`.`category_id`=`product_category`.`pro_cate_id` AND `category_size_mapping`.`size_types_id`=`size_types`.`size_types_id` ORDER BY `category_size_mapping`.`id` DESC";

                            if ($result_size_types_mapping = $connection->query($sql_size_types_mapping)){

                                $slno = 0;
                                while($row_size_types_mapping = $result_size_types_mapping->fetch_assoc()) {

                                    $slno++;
                                    if($row_size_types_mapping['status'] == 1)
                                        $status = "<a href=\"status/size_types_mapping_status.php?size_types_mapping_id=$row_size_types_mapping[id]\" class=\"btn btn-primary\">In-Active</a>";
                                    else
                                        $status = "<a href=\"status/size_types_mapping_status.php?size_types_mapping_id=$row_size_types_mapping[id]\" class=\"btn btn-primary\">Active</a>";

                                    print "<tr>";
                                    print "<td>$slno</td>";
                                    print "<td>$row_size_types_mapping[category]</td>";
                                    print "<td>$row_size_types_mapping[size_types]</td>";
                                    print "<td>$status</td>";
                                    print "</tr>";
                                }
                            }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<?php

require_once "include/footer.php";
?>

