<?php 
session_start();

/** For Wish List **/
$_SESSION['page'] = $_SERVER['PHP_SELF'];
$_SESSION['id'] = $_GET['id'];

include 'include/header.php';
?>
  <!-- HEADER END --> 
  
  <!-- CONTAIN START -->
  <section class="container pb-85 pt-30">
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="shorting mt-10 mb-20">
          <div class="row">
            <div class="col-md-12">
              <div class="show-item float-left-sm">
                <div class="catagorey-head">
                  <ul>
                    <li class="home"><a href="index.php"><i class="fa fa-home"></i></a></li>
                    <li class="divider"><i class="fa fa-angle-double-right"></i></li>
                    <li>
                        <h4>
                        <?php
                        $sql_category = $connection->query("select * from `product_category` where `pro_cate_id` = '$_GET[id]'");
                        $row_category = $sql_category->fetch_assoc();

                        print $row_category['pro_cate_name'];
                        ?>
                        </h4>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-6">
            </div>
          </div>
        </div><hr class="mtb-10">
        <div class="product-listing">
          <div class="row mlr_-20">
            <?php
            if($sql_1 = $connection->query("select * from `product_name` where `pro_cate_id` = '$_GET[id]'")){
                while($row = $sql_1->fetch_assoc()){
            ?>
            <div class="col-md-3 col-xs-6 plr-20 mx-auto">
              <div class="product-item">
                <div class="product-image">
                  <a href="product-detail.php?id=<?php print $row['pro_name_id']; ?>">
                    <img src="<?php print "product_name_banner/".$row['banner']; ?>" alt="<?php print $row['pro_name']; ?>r">
                  </a>
                  <div class="product-detail-inner">
                    <div class="detail-inner-left align-center">
                      <ul>
                        <li class="pro-compare-icon"><a href="product-detail.php?id=<?php print $row['pro_name_id']; ?>"></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="product-item-details">
                  <div class="product-item-name">
                    <a href="product-detail.php?id=<?php print $row['pro_name_id']; ?>">
                       <?php 
                       $sql_2 = $connection->query("select * from `product_name` where  `product_name`.`pro_name_id` = '$row[pro_name_id]'");
                        $row_product_name = $sql_2->fetch_assoc();

                        print $row_product_name['pro_name'];
                       ?>     
                    </a>
                  </div>                  
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
  </section>

  <!-- CONTAINER END --> 
<?php include 'include/footer.php';?>  
