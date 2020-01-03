<?php
if (session_status()==PHP_SESSION_NONE) {
    session_start();
}
//Include Databse Connection Page
require_once "database/connection.php";
//Include Finish
?>

<!DOCTYPE html>
<html lang="en">
<head>
<!-- ======================= Basic Page Needs =========================== -->
<meta charset="utf-8">
<title>3 Star || Online store for plastic buckets, mugs, jugs, basin etc.</title>
<!-- SEO Meta ================================================== -->
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="distribution" content="global">
<meta name="revisit-after" content="2 Days">
<meta name="robots" content="ALL">
<meta name="rating" content="8 YEARS">
<meta name="Language" content="en-us">
<meta name="GOOGLEBOT" content="NOARCHIVE">
<!-- Mobile Specific Metas
  ================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<!-- CSS
  ================================================== -->
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="css/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="css/fotorama.css">
<link rel="stylesheet" type="text/css" href="css/magnific-popup.css">
<link rel="stylesheet" type="text/css" href="css/custom.css">
<link rel="stylesheet" type="text/css" href="css/responsive.css">

<link rel="shortcut icon" href="images/favicon.html">
<link rel="apple-touch-icon" href="images/apple-touch-icon.html">
<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.html">
<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.html">
<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="css/responsive.dataTables.min.css">
</head>
<body>
<div class="main">
  <!-- HEADER START -->
  <header class="navbar navbar-custom" id="header">
    <div class="header-middle">
      <div class="container">
        <div class="header-inner">
          <div class="row m-0">
            <div class="col-md-4 col-sm-12"></div>
            <div class="col-md-4 col-sm-12">
              <div class="navbar-header float-none-sm">
                <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button"><i class="fa fa-bars"></i></button>
                <a class="navbar-brand page-scroll" href="index.php">
                  <img alt="Streetwear" src="images/logo.png">
                </a>
              </div>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="header-right-part right-side float-none-sm">
                <ul>
                  <li class="content hide-lg">
                    <a class="content-link">
                      <span class="content-icon"></span>
                      <div class="header-right-text" style="margin-left: 5px">My Profile</div>
                    </a>
                    <div class="content-dropdown">
                      <ul style="text-transform: uppercase;">
                        <?php
                        if (!empty($_SESSION['user_id'])){
                        ?>
                        <li class="login-icon"><i class='fa fa-angle-right' aria-hidden='true'></i><a class="pretext" href="my_account.php" title="My Account">My Account</a></li>
                        <li class="login-icon"><i class='fa fa-angle-right' aria-hidden='true'></i><a class="pretext" href="mywishlist.php" title="My Wishlist">My Wishlist</a></li>
                        <li class="login-icon"><i class='fa fa-angle-right' aria-hidden='true'></i><a href="myorder.php" class="pretext" title="My Wishlist">My Orders</a></li>
                        <li class="login-icon"><i class='fa fa-angle-right' aria-hidden='true'></i><a class="pretext" href="logout.php" title="Login">Signout</a></li>
                        <?php
                        } else {
                        ?>
                        <li class="login-icon"><i class='fa fa-angle-right' aria-hidden='true'></i><a class="pretext" href="login.php" title="Login">Signin</a></li>
                        <li class="login-icon"><i class='fa fa-angle-right' aria-hidden='true'></i><a class="pretext" href="signup.php" title="Login">Signup</a></li>
                        <?php
                        }
                        ?>
                      </ul>
                    </div>
                  </li>
                  <li class="cart-icon"><!-- -4px -145px -->
                    <a href="#">
                      <span>
                        <small class="cart-notification">
                           <?php 
                           if(isset($_SESSION['cart']))
                              print count($_SESSION['cart']);
                           else
                              print "0"; 
                           ?>
                        </small>
                      </span>
                      <div class="header-right-text">My Cart</div>
                    </a>
                    <div class="cart-dropdown header-link-dropdown">
                      <?php
                        if (!empty($_SESSION['cart'])) {
                          if( count($_SESSION['cart']) > 0 ){
                      ?>
                        <ul class="cart-list link-dropdown-list">
                          <?php
                            $total = 0;
                              foreach ($_SESSION['cart'] as $product_id => $quantity) {
                                if($sql_product = $connection->query("select `products`.*, `product_name`.`banner`, `product_name`.`pro_name` from `products`, `product_name` where `products`.`id` = '$product_id' and `products`.`pro_name_id` = `product_name`.`pro_name_id`")){
                                     while($row_product = $sql_product->fetch_assoc()){
                          ?>
                          <li> 
                            <a class="close-cart" href="php/add_cart.php?product_id=<?php print $product_id; ?>"><i class="fa fa-times-circle"></i></a>
                            <div class="media"> 
                              <a class="pull-left"> <img alt="<?php print $row_product['pro_name']; ?>" src="<?php print "product_name_banner/".$row_product['banner']; ?>"></a>
                              <div class="media-body">
                                <span><a><?php print $row_product['pro_name']; ?></a></span>
                                <p class="cart-price">
                                ₹
                                <?php
                                $total_pieces = ($row_product['standard_packing_in_piece'] * $quantity);
                                $sub_total = ($row_product['per_piece_price'] * $total_pieces);

                                print $sub_total;
                                ?>
                                </p>
                                <div class="product-qty">
                                  <div class="custom-qty">
                                    <input type="text" name="qty" value="<?php print $quantity; ?>" title="Qty" class="input-text qty">
                                  </div>
                                </div>
                              </div>
                            </div>
                          </li>
                          <?php
                                        }
                                    }
                                }
                          ?>
                          <div class="mt-20">
                            <a href="cart.php" class="btn-color btn" style="width: 100%">View Cart</a>
                          </div>
                           </ul>
                          <?php
                            }
                        
                        } else{
                        ?>
                        <div>
                            <img src="images/no-product.png">
                            <div class="clearfix"></div>
                            <h4 class="cart-sub-totle">Your cart is empty</h4>
                        </div>
                        <?php
                        }
                        ?>                      
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="header-bottom">
      <div class="container">
        <div id="menu" class="navbar-collapse collapse left-side align-center" >
          <ul class="nav navbar-nav">
            <li class="level"><a href="index.php" class="page-scroll">Home</a></li>
            <?php
            if($sql_category = $connection->query("select * from `product_category` limit 0, 6")){
                while($row_category = $sql_category->fetch_assoc()){
            ?>
            <li>
              <a href="product-list.php?id=<?php print $row_category['pro_cate_id']; ?>" class="page-scroll"><?php print $row_category['pro_cate_name']; ?></a>
            </li>
            <?php
                }
            }
            ?>
            <li class="level dropdown">
              <span class="opener plus"></span>
              <a class="page-scroll">More Products <i class="fa fa-angle-down hidden-xs"></i></a>
              <div class="megamenu mobile-sub-menu">
                <div class="megamenu-inner-top">
                  <ul class="sub-menu-level1">
                    <li class="level2">
                      <ul class="sub-menu-level2 ">
                        <?php
                        if($sql_category = $connection->query("select * from `product_category` limit 7, 100")){
                             while($row_category = $sql_category->fetch_assoc()){
                        ?>
                        <li class="level3"><a href="product-list.php?id=<?php print $row_category['pro_cate_id']; ?>"><?php print $row_category['pro_cate_name']; ?></a></li>
                        <?php
                            }
                        }
                        ?>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <!-- HEADER END --> 