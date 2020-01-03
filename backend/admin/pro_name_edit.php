<?php

require_once "include/header.php";

if (!empty($_GET['pro_name_id'])){

    $pro_name_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['pro_name_id']));

    $sql_pro_name = "SELECT * FROM `product_name` WHERE `pro_name_id`='$pro_name_id'";

    if ($result_pro_name = $connection->query($sql_pro_name))
        $row_pro_name = $result_pro_name->fetch_assoc();
}

//User Registration
if(isset($_POST['submit'])){

    if (!empty($_POST['pro_cate_id']) && !empty($_POST['pro_name'])) {
        
        $pro_cate_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['pro_cate_id']));
        $pro_name = ucwords($connection->real_escape_string(mysql_entities_fix_string($_POST['pro_name'])));
        
        if ($pro_name != $row_pro_name['pro_name']) {
            
            $pro_name_count_sql = "SELECT * FROM `product_name` WHERE `pro_name`='$pro_name'";
            if ($pro_name_count = $connection->query($pro_name_count_sql)) {

                if ($pro_name_count->num_rows == 0) {

                    $pro_name_update_sql ="UPDATE `product_name` SET `pro_cate_id`='$pro_cate_id', `pro_name`='$pro_name' WHERE `pro_name_id`='$pro_name_id'";

                    if ($connection->query($pro_name_update_sql)){

                        if (!empty($_FILES['banner']['name'])) {
                            
                            $ext = explode(".", $_FILES['banner']['name']);
                            $ext = end($ext);
                            $ext = strtolower($ext);

                            @mkdir("../../product_name_banner");
                            $path = time().".".$ext;
                            
                            unlink("../../product_name_banner/".$row_pro_name['banner']);

                            $product_name_banner_update = "UPDATE `product_name` SET `banner` = '$path' WHERE `pro_name_id` = '$pro_name_id'";

                            if ($connection->query($product_name_banner_update)) {

                                move_uploaded_file($_FILES['banner']['tmp_name'], "../../product_name_banner/".$path);
                            }
                        }

                        print "<script>window.location.href='all_product_name.php';</script>";
                    }
                    else
                        showMessage(3);
                } else
                    showMessage(4);
            } else
                showMessage(3);
        } else {

            $pro_name_update_sql ="UPDATE `product_name` SET `pro_cate_id`='$pro_cate_id' WHERE `pro_name_id`='$pro_name_id'";

            if ($connection->query($pro_name_update_sql)){

                if (!empty($_FILES['banner']['name'])) {
                            
                    $ext = explode(".", $_FILES['banner']['name']);
                    $ext = end($ext);
                    $ext = strtolower($ext);

                    @mkdir("../../product_name_banner");
                    $path = time().".".$ext;
                            
                    unlink("../../product_name_banner/".$row_pro_name['banner']);

                    $product_name_banner_update = "UPDATE `product_name` SET `banner` = '$path' WHERE `pro_name_id` = '$pro_name_id'";

                    if ($connection->query($product_name_banner_update)) {

                        move_uploaded_file($_FILES['banner']['tmp_name'], "../../product_name_banner/".$path);
                    }
                }

                print "<script>window.location.href='all_product_name.php';</script>";
            }
            else
                showMessage(3);
        }
    } else
        showMessage(1);   
}
//End of User Registration

//Start of Messsage Checking Function
function showMessage($msg) {
    if ($msg == 1)
        print "<script>Swal.fire('Warning', 'Please ! Enter required fields', 'question')</script>";
    if ($msg == 3)
        print "<script>Swal.fire('Danger', 'Something wrong while updating.', 'question')</script>";
    if ($msg == 4)
        print "<script>Swal.fire('Info', 'Product Name already available.')</script>";
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

//Start of Thumbnail
function imageResize ($source, $destination, $width, $height) {

    $ext = explode(".", $source);
    $ext = end($ext);
    $ext = strtolower($ext);
    $image = "";

    if ($ext == "jpg" || $ext == "jpeg")
        $image = imagecreatefromjpeg($source);
    if ($ext=="png")
        $image = imagecreatefrompng($source);
    if ($ext=="bmp")
        $image = imagecreatefrombmp($source);
    if ($ext=="gif")
        $image = imagecreatefromgif($source);

    $tmp = imagecreatetruecolor($width, $height);

    imagecopyresized($tmp, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));

    imagejpeg($tmp, $destination);
}
//End of Thumbnail
?>     

<div class="right_col" role="main">
  <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Edit Product Name</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"><br />
                <!-- Section For New User registration -->
                <form method="POST" autocomplete="off" class="form-horizontal form-label-left" enctype="multipart/form-data">

                    <div class="well" style="overflow: auto">
                        <div class="form-row mb-3">
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="pro_cate_id">Category</label>
                                <select name="pro_cate_id" class="form-control" required>
                                    <option selected disabled>Choose Category</option>
                                    <?php
                                    $retrive_pro_cate_sql = "SELECT * FROM `product_category` ORDER BY `pro_cate_id` ASC";

                                    if ($result_pro_cate = $connection->query($retrive_pro_cate_sql)) 
                                        while ($row_pro_cate = $result_pro_cate->fetch_assoc()){

                                            if ($row_pro_name['pro_cate_id'] == $row_pro_cate['pro_cate_id'])
                                                print "<option value=\"$row_pro_cate[pro_cate_id]\" selected>$row_pro_cate[pro_cate_name]</option>";
                                            else
                                               print "<option value=\"$row_pro_cate[pro_cate_id]\">$row_pro_cate[pro_cate_name]</option>"; 
                                        }
                                    ?>
                                  </select>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="pro_name">Product Name</label>
                                <input type="text" name="pro_name"  class="form-control" placeholder="Enter Product Name" value="<?php print $row_pro_name['pro_name']; ?>" required>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-12 mb-3">
                                <label for="size">Product Name Banner</label>
                                <input type="file" name="banner" class="form-control " accept="image/*">
                            </div>
                        </div>
                    </div>

                  <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" name="submit" class="btn btn-success">Save Product Name</button>
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