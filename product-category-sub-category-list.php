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
                    <li class="home"><i class="fa fa-home"></i></li>
                    <li class="divider"><i class="fa fa-angle-double-right"></i></li>
                    <li><h4>Bucket</h4></li>
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
            if(!empty($_GET['page']) > 0)
                $page = $_GET['page'];
            else
                $page = 1;

            $limit = ($page * 4) - 4;

            if($sql_1 = $connection->query("select * from `products`, `products_cover` where `products`.`id` = `products_cover`.`product_id` and `products`.`pro_cate_id` = '$_GET[id]' limit $limit, 4")){
                while($row = $sql_1->fetch_assoc()){
            ?>
            <div class="col-md-3 col-xs-6 plr-20">
              <div class="product-item">
                <div class="product-image">
                  <a href="product-detail.php?id=<?php print $row['id']; ?>">
                    <img src="<?php print "product_cover/".$row['product_cover_photo']; ?>" alt="Streetwear">
                  </a>
                  <div class="product-detail-inner">
                    <div class="detail-inner-left align-center">
                      <ul>
                        <li class="pro-wishlist-icon"><a href="php/add_wishlist.php?product_id=<?php print $row['id']; ?>"></a></li>
                        <li class="pro-compare-icon"><a href="product-detail.php?id=<?php print $row['id']; ?>"></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="product-item-details">
                  <div class="product-item-name">
                    <a href="product-detail.php?id=<?php print $row['id']; ?>">
                       <?php 
                       $sql_2 = $connection->query("select * from `product_name` where  `product_name`.`pro_name_id` = '$row[pro_name_id]'");
                        $row_product_name = $sql_2->fetch_assoc();

                        print $row_product_name['pro_name'];
                       ?>     
                    </a>
                  </div>
                  <div class="products-feature mb-10">
                      <div class="row">                          
                        <div class="col-md-6 col-xs-12">
                            <b><i class="fa fa-circle"></i>&nbsp;
                            <?php 
                            $sql_cover = $connection->query("select * from `cover` where `cover_id` = '$row[cover_id]'");
                            $row_cover = $sql_cover->fetch_assoc();

                            print $row_cover['cover_name'];
                            ?></b>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <b><i class="fa fa-circle"></i>&nbsp;
                                <?php
                                if ($row['print'] == 1) 
                                    print "Without Printing";
                                else if($row['print'] == 2)
                                    print "NA";
                                else if($row['print'] == 3)
                                    print "Printing";
                                else
                                    print "With Printing";
                                ?>
                            </b>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <b><i class="fa fa-circle"></i>&nbsp;
                            <?php 
                            $sql_size = $connection->query("select * from `sizes` where `size_id` = '$row[size_id]'");
                            $row_size = $sql_size->fetch_assoc();

                            print $row_size['size_name'];

                            $sql_size_types = $connection->query("select * from `size_types` where `size_types_id` = '$row[size_type_id]'");
                            $row_size_types = $sql_size_types->fetch_assoc();

                            print $row_size_types['size_types'];
                            ?>
                            </b>
                        </div>                       
                        <div class="col-md-6 col-xs-12">
                            <b><i class="fa fa-circle"></i>&nbsp;
                            <?php 
                            $sql_varient = $connection->query("select * from `varient` where `varient_id` = '$row[varient_id]'");
                            $row_varient = $sql_varient->fetch_assoc();

                            print $row_varient['varient'];
                            ?>
                            </b>
                        </div>
                      </div>
                  </div>
                  <div class="price-box">
                    <span class="price">
                        ₹
                    <?php
                    $discount = ($row['per_piece_price'] * $row['discount']) / 100;
                    $selling_amount = ($row['per_piece_price'] - $discount);

                    print $selling_amount;
                    ?>
                    </span>
                    <del class="price old-price">
                        ₹
                    <?php
                    print $row['per_piece_price'];
                    ?>
                    </del>
                  </div>
                </div>
              </div>
            </div>
            <?php
                }
            }
            ?>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="pagination-bar">
                <ul>
                    <?php

                    $sql_2 = $connection->query("select * from `products`, `products_cover` where `products`.`id` = `products_cover`.`product_id` and `products`.`pro_name_id` = '$_GET[id]'");

                    $total=$sql_2->num_rows;

                    if($page > 1){

                        $prev = $page - 1;

                        print "<li><a href=\"product-list.php?page=$prev&id=$_GET[id]\"><i class=\"fa fa-angle-left\"></i></a></li>";
                    }

                    $no_page = ceil($total/4);

                    for($i = 1; $i <= $no_page; $i++){

                        if($page == $i)
                            print "<li class=\"active\"><a href=\"product-list.php?page=$i&id=$_GET[id]\">$i</a></li>";
                        else
                            print "<li><a href=\"product-list.php?page=$i&id=$_GET[id]\">$i</a></li>";
                    }

                    if($page < $no_page){

                        $next = $page + 1;
                                        
                        print "<li><a href=\"product-list.php?page=$next&id=$_GET[id]\"><i class=\"fa fa-angle-right\"></i></a></li>";
                    }
                    ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTAINER END --> 
<?php include 'include/footer.php';?>  
