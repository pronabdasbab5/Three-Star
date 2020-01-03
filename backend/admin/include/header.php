<?php 
if(session_status() === PHP_SESSION_NONE) session_start();

if (empty($_SESSION['admin_user_id']))
  header("location:../index.php");

//Include Databse Connection Page
require_once "database/connection.php";
//Include Finish
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Three Star Admin Panel</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="../vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <style type="text/css">
    #chart-container {
        width: 640px;
        height: auto;
    }
    </style>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col" style="height: 100%">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="dashboard.php" class="site_title"><span>Three Star Admin Panel</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <!-- <div class="profile_pic">
                <img src="images/img.jpg" alt="..." class="img-circle profile_img">
              </div> -->
              <center>
                  <div class="profile_info">
                    <span>Welcome To,</span>
                    <h2><?php print $_SESSION['admin_name']; ?></h2>
                    <h6><?php print "Last Login Date : ".$_SESSION['last_login_date']; ?></h6>
                  </div>
              </center>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li>
                    <a href="dashboard.php"><i class="fa fa-home"></i> Home </a>
                  </li>
                  <li><a><i class="fa fa-edit"></i> Manage Products <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="new_product.php">New Product </a></li>
                        <li><a href="stock_update.php">Stock Update </a></li>
                        <li><a href="out_of_stock.php">Out of Stock </a></li>
                        <li><a href="all_product.php">All Product </a></li>
                        <li><a>Product Name<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li><a href="new_product_name.php">New Product Name</a></li>
                            <li><a href="all_product_name.php">All Product Name</a></li>
                          </ul>
                        </li>
                    </ul>
                  </li>
                  <li>
                    <a><i class="fa fa-edit"></i> Manage Order <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="new_orders.php">New Order</a></li>
                        <li><a href="accept_orders.php">Accepted Order</a></li>
                        <li><a href="cancel_orders.php">Cancel Order</a></li>
                    </ul>
                  </li>
                  <li>
                    <a><i class="fa fa-edit"></i> Manage Users <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="all_user.php">All Users</a></li>
                    </ul>
                  </li>
                  <li>
                    <a><i class="fa fa-edit"></i> Configuration <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="size_type_mapping.php">Manage Size Types Mapping</a></li>
                    </ul>
                  </li>
                  <li>
                    <a><i class="fa fa-edit"></i> Manage Master <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a>Size Types<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li><a href="new_size_type.php">New Size Type</a></li>
                            <li><a href="all_size_type.php">All Size Type</a></li>
                          </ul>
                        </li>
                        <li><a>Size<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li><a href="new_size.php">New Size </a></li>
                            <li><a href="all_size.php">All Size </a></li>
                          </ul>
                        </li>
                        <li><a>Varient<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li><a href="new_varient.php">New Varient </a></li>
                            <li><a href="all_varient.php">All Varient </a></li>
                          </ul>
                        </li>
                        <li><a>Cover<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li><a href="new_cover.php">New Cover </a></li>
                            <li><a href="all_cover.php">All Cover </a></li>
                          </ul>
                        </li>
                        <li><a>Packing System<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li><a href="new_packing_system.php">New Packing System </a></li>
                            <li><a href="all_packing_system.php">All Packing System </a></li>
                          </ul>
                        </li>
                    </ul>
                  </li>
                  <li>
                    <a><i class="fa fa-edit"></i> Manage Category <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="new_product_category.php">New Product Category</a></li>
                        <li><a href="all_product_category.php">All Product Category</a></li>
                    </ul>
                  </li>
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="admin_logout.php">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="images/img.jpg" alt=""><?php print $_SESSION['admin_name']; ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="forgot_password.php"> Forgot Password</a></li>
                    <li><a href="admin_logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

                <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">
                        <?php
                        $order_cnt = 0;

                        $order_count_sql = "SELECT * FROM `orders` WHERE `status`=1";

                        if ($order_count = $connection->query($order_count_sql))
                            $order_cnt = $order_count->num_rows;

                        $notification_cnt = $order_cnt;

                        print $notification_cnt;
                        ?>
                    </span>
                  </a>
                  
                    <?php

                    if (($order_cnt > 0)) {

                        print "<ul id=\"menu1\" class=\"dropdown-menu list-unstyled msg_list\" role=\"menu\">";

                        if ($order_cnt > 0)
                            print "<li><div class=\"text-center\"><a href=\"new_orders.php\" style=\"text-decoration: none;\"><strong>($order_cnt) New Orders</strong></a></div></li>";

                        print "</ul>";
                    }
                    ?> 
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->