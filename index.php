<?php include 'include/header.php';?>

  <!-- Slider STRAT -->
  <section>
    <div class="banner">
      <div class="main-banner">
        <div class="banner-1"> 
          <img src="images/banner4.jpg" alt="Streetwear"> 
          <div class="banner-detail">
            <div class="row">
              <div class="col-md-1 col-sm-1 col-xs-1"></div>
              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="banner-detail-inner">
                  <span class="offer">Hot Offer</span>
                  <h1 class="banner-title">Colourful Buckets</h1>
                  <h1 class="banner-subtitle">Design Your Bathroom</h1>
                  <a href="shop.html" class="btn btn-black">Shop Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="banner-2"> 
          <img src="images/banner1.jpg" alt="Streetwear">
          <div class="banner-detail">
            <div class="row">
              <div class="col-md-1 col-sm-1 col-xs-1"></div>
              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="banner-detail-inner">
                  <span class="offer">Hot Offer</span>
                  <h1 class="banner-title">Best Household items </h1>
                  <h1 class="banner-subtitle">Easy on your eyes and comfortable <span>in your hand</span></h1>
                  <a href="shop.html" class="btn btn-black">Shop Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="banner-1"> 
          <img src="images/banner3.jpg" alt="Streetwear">
          <div class="banner-detail">
            <div class="row">
              <div class="col-md-6 col-sm-6 col-xs-6"></div>
              <div class="col-md-6 col-sm-6 col-xs-6">
                <div class="banner-detail-inner">
                  <span class="offer">How would you like our</span>
                  <h1 class="banner-title">Attarctive Kitchenware</h1>
                  <h1 class="banner-subtitle">Plates, Glasses, Spoons Set</h1>
                  <a href="shop.html" class="btn btn-black">Shop Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Slider END --> 

  <!--  Featured Products Slider Block Start  -->
  <section class="container">
    <div class="pt-85 pb-30">
      <div class="product-slider owl-slider">
        <div class="row">
          <div class="col-xs-12">
            <div class="heading-part align-center mb-40">
              <h2 class="main_title">Lastest Products</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="product-slider-main position-r">
            <div class="owl-carousel pro_cat_slider">
                <?php
                    $sql_pro_name = "SELECT DISTINCT * FROM `product_name` ORDER BY RAND() LIMIT 15";

                    if ($result_pro_name = $connection->query($sql_pro_name))
                    {
                        while($row_pro_name = $result_pro_name->fetch_assoc()) 
                        {
                ?>
                <div class="item">
                    <div class="product-item">
                      <div class="product-image">
                        <div class="sale-label"><span>Sale</span></div>
                        <a href="product-list.php?id=<?php print $row_pro_name['pro_name_id']; ?>">
                          <img src="<?php print "product_name_banner/".$row_pro_name['banner']; ?>" alt="Streetwear">
                        </a>
                        <div class="product-detail-inner">
                          <div class="detail-inner-left align-center">
                            <ul>
                              <li class="pro-wishlist-icon"><a href="#"></a></li>
                              <li class="pro-compare-icon"><a href="product-detail.php?id=<?php print $row_pro_name['pro_name_id']; ?>"></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="product-item-details">
                        <div class="product-item-name">
                          <a href="product-detail.php?id=<?php print $row_pro_name['pro_name_id']; ?>"><?php print $row_pro_name['pro_name']; ?></a>
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
    </div>
  </section>
  <!--  Featured Products Slider Block End  -->

  <!-- banner block Start  -->
  <section class="bg-off-white">
    <div class="pb-85 pt-30 brand-main">        
      <div class="row">
        <div class="col-xs-12">
          <div class="heading-part align-center mb-40">
            <h2 class="main_title">Exciting Offer</h2>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="brand">
            <div id="brand-logo" class="owl-carousel align_center">
              <div class="item"><a href="#"><img src="images/banner/2.jpg" alt="#"></a></div>
              <div class="item"><a href="#"><img src="images/banner/1.jpg" alt="#"></a></div>
              <div class="item"><a href="#"><img src="images/banner/3.jpg" alt="#"></a></div>
              <div class="item"><a href="#"><img src="images/banner/6a.jpg" alt="#"></a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- banner block End  --> 

  <!-- long banner Start -->
  <section>
    <div class="align-center">
      <img src="images/banner/4.jpg">
    </div>
  </section>
  <!-- long banner Start -->

  <!-- New Products Slider Block Start  -->
  <section class="container">
    <div class="pt-30">
      <div class="product-slider owl-slider">
        <div class="row">
          <div class="col-xs-12">
            <div class="heading-part align-center mb-40">
              <h2 class="main_title">Top Selling Products</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="product-slider-main position-r">
            <div class="owl-carousel pro_cat_slider">
              <?php
                  $sql_pro_name = "SELECT DISTINCT `best_seller_product`.`pro_name_id`, `product_name`.`pro_name`, `product_name`.`banner` FROM `product_name`, `best_seller_product` WHERE `best_seller_product`.`pro_name_id` = `product_name`.`pro_name_id` ORDER BY `product_name`.`pro_name_id` DESC";

                  if ($result_pro_name = $connection->query($sql_pro_name)){
                      while($row_pro_name = $result_pro_name->fetch_assoc()) {
              ?>
              <div class="item">
                <div class="product-item">
                  <div class="product-image">
                    <div class="sale-label"><span>Sale</span></div>
                    <a href="product-list.php?id=<?php print $row_pro_name['pro_name_id']; ?>">
                      <img src="<?php print "product_name_banner/".$row_pro_name['banner']; ?>" alt="Streetwear">
                    </a>
                    <div class="product-detail-inner">
                      <div class="detail-inner-left align-center">
                        <ul>
                          <li class="pro-wishlist-icon"><a href="#"></a></li>
                          <li class="pro-compare-icon"><a href="product-detail.php?id=<?php print $row_pro_name['pro_name_id']; ?>"></a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="product-item-details">
                    <div class="product-item-name">
                      <a href="product-detail.php?id=<?php print $row_pro_name['pro_name_id']; ?>"><?php print $row_pro_name['pro_name']; ?></a>
                    </div>
                    <div class="price-box">
                      <span class="price"></span>
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
    </div>
  </section>
  <!--  New Products Slider Block End  -->

  <!-- Blog strat -->
  <section class="container">
    <div class="pb-85 pt-30">
      <div class="row">
        <div class="col-xs-12">
          <div class="heading-part align-center mb-40">
            <h2 class="main_title">Top Selling Products</h2>
          </div>
        </div>
      </div>
      <div class="blog-main">
        <div class="owl-slider">
          <div class="blog_slider owlcarousel m-0">
            <div class="item p-0">
              <div class="blog-item">
                  <img src="images/banner/10.jpg" alt="Streetwear">
              </div>
            </div>
            <div class="item p-0">
              <div class="blog-item">
                  <img src="images/banner/11.jpg" alt="Streetwear">
              </div>
            </div>
            <div class="item p-0">
              <div class="blog-item">
                  <img src="images/banner/12.jpg" alt="Streetwear">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Blog end -->

  <!-- CONTAINER END --> 
<?php include 'include/footer.php';?>  