<?php

require_once "include/header.php";

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
                  <div class="col-md-12">
                    <div class="x_panel">
                      <div class="x_title">
                        <h2>Product Name <small> Slider Image </small></h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="x_content">

                        <div class="row">
                            <?php
                            $product_name_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['product_name_id']));
                            $sql_product_name_slider = "SELECT * FROM `product_name_slider` WHERE `product_name_id`='$product_name_id'";

                            if ($result_product_name_slider = $connection->query($sql_product_name_slider)){
                                while($row_product_name_slider = $result_product_name_slider->fetch_assoc()){
                            ?>

                            <div class="col-md-55">
                                <div class="thumbnail">
                                  <div class="image view view-first">
                                    <img style="width: 100%; display: block;" src="../../product_name_slider/<?php print $row_product_name_slider['slider']; ?>" alt="image" />
                                  </div>
                                  <div class="caption">
                                    <form method="POST" action="php/product_name_slider_update.php" enctype="multipart/form-data" autocomplete="off">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="hidden" name="product_slider_id" required value="<?php print $row_product_name_slider['id']; ?>">
                                                <input type="file" name="slider" accept="image/*" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="submit" name="submit" value="Update" class="btn btn-primary">
                                            </div>
                                        </div>
                                    </form>
                                  </div>
                                </div>
                            </div>

                            <?php
                                }
                            }
                            ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
</div>
<?php
require_once "include/footer.php";
?>