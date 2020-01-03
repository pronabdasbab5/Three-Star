<?php

require_once "include/header.php";

//User Registration
if(isset($_POST['submit'])){

    if (!empty($_POST['pro_cate_id']) && !empty($_POST['pro_name']) && !empty($_FILES['banner']['name']) && !empty($_FILES['slider']['name'])) {
        
        $pro_cate_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['pro_cate_id']));
        $pro_name = ucwords($connection->real_escape_string(mysql_entities_fix_string($_POST['pro_name'])));

        $pro_name_count_sql = "SELECT * FROM `product_name` WHERE `pro_name`='$pro_name'";

        if ($pro_name_count = $connection->query($pro_name_count_sql)) {

            if($pro_name_count->num_rows == 0) {

                $current_date = date('d-m-Y');
                $pro_name_add_sql = "INSERT INTO `product_name` (`pro_cate_id`, `pro_name` , `created_at`) VALUES ('$pro_cate_id', '$pro_name', '$current_date')";

                if($connection->query($pro_name_add_sql)){

                    $ext = explode(".", $_FILES['banner']['name']);
                    $ext = end($ext);
                    $ext = strtolower($ext);

                    @mkdir("../../product_name_banner");
                    $path = time().".".$ext;
                    $product_name_id = $connection->insert_id;

                    $product_name_banner_update = "UPDATE `product_name` SET `banner` = '$path' WHERE `pro_name_id` = '$product_name_id'";

                    if ($connection->query($product_name_banner_update)) {

                        move_uploaded_file($_FILES['banner']['tmp_name'], "../../product_name_banner/".$path);
                    }

                    for ($i=0; $i < count($_FILES['slider']['name']); $i++) { 

                        $image = $_FILES['slider']['name'];
                        $ext = explode(".", $image[$i]);
                        $ext = end($ext);
                        $ext = strtolower($ext);

                        @mkdir("../../product_name_slider");
                        $path_add_img = time().$i.".".$ext;

                        $product_name_slider_sql ="INSERT INTO `product_name_slider` ( `product_name_id`, `slider`) VALUES ('$product_name_id', '$path_add_img')";
                        $connection->query($product_name_slider_sql);

                        move_uploaded_file($_FILES['slider']['tmp_name'][$i], "../../product_name_slider/".$path_add_img);
                    }

                    showMessage(2);
                }
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
        print "<script>Swal.fire({position: 'top-end', type: 'success', title: 'Product Name has been added successfully', showConfirmButton: false, timer: 1500})</script>";
    if ($msg == 3)
        print "<script>Swal.fire('Danger', 'Something wrong while adding.', 'question')</script>";
    if ($msg == 4)
        print "<script>Swal.fire('Info', 'Product Name already added.')</script>";
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
                <h2>New Product Name</h2>
                <div class="clearfix"></div>
              </div>
              <div class="x_content"><br />
                <!-- Section For New User registration -->
                <form method="POST" autocomplete="off" class="form-horizontal form-label-left" enctype="multipart/form-data">
                    <div class="well" style="overflow: auto">
                        <div class="form-row mb-3">
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="pro_cate_id">Category</label>
                                <select name="pro_cate_id"  class="form-control col-md-7 col-xs-12" required>
                                    <option selected disabled>Choose Category</option>
                                    <?php
                                    $retrive_pro_cate_sql = "SELECT * FROM `product_category` WHERE `status`='1' ORDER BY `pro_cate_id` ASC";

                                    if ($result_pro_cate = $connection->query($retrive_pro_cate_sql)) 
                                        while ($row_pro_cate = $result_pro_cate->fetch_assoc())
                                            print "<option value=\"$row_pro_cate[pro_cate_id]\">$row_pro_cate[pro_cate_name]</option>";
                                    ?>
                                  </select>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="size">Product Name</label>
                                <input type="text" name="pro_name"  class="form-control" placeholder="Enter Product Name" required>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="size">Banner</label>
                                <input type="file" name="banner" class="form-control " accept="image/*" required>
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12 mb-3">
                                <label for="size">Slider</label>
                                <input type="file" name="slider[]" class="form-control " accept="image/*" required multiple>
                            </div>
                        </div>
                    </div>
                  <div class="ln_solid"></div>
                    <div class="form-group">
                      <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <button type="submit" name="submit" class="btn btn-success">Add Product Name</button>
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