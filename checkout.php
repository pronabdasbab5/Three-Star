<?php 
session_start();
if (empty($_SESSION['user_id'])) 
    header('location: login.php');

if (empty($_SESSION['cart'])) 
    header('location: index.php');

include 'include/header.php';
?>
  <!-- CONTAINER START --> 

  <section class="container">
    <div class="ptb-55">
      <div class="row">
        <div class="checkout-step mb-40">
          <ul>
            <li class="active"> 
              <a href="cart.php">
                <div class="step">
                  <div class="line"></div>
                  <div class="circle">1</div>
                </div>
                <span class="hidden-xs" style="color: #ff6666;font-weight: 700;">Cart</span>
              </a>
            </li>
            <li class="active"> 
              <a href="checkout.php">
                <div class="step">
                  <div class="line"></div>
                  <div class="circle">2</div>
                </div>
                <span class="" style="color: #ff6666;font-weight: 700;">Shipping</span>
              </a>
            </li>
            <li>
              <a href="payment.html">
                <div class="step">
                  <div class="line"></div>
                  <div class="circle">3</div>
                </div>
                <span class="hidden-xs" style="font-weight: 500!important;color: #2a2931;">Payment</span>
              </a>
            </li>
            <li>
              <a href="order-complete.html">
                <div class="step">
                  <div class="line"></div>
                  <div class="circle">4</div>
                </div>
                <span class="hidden-xs" style="color: #2a2931;font-weight: 500!important;">Order Confirmation</span>
              </a>
            </li> 
          </ul>
          <hr>
        </div>
        <div class="col-sm-8 mb-xs-30">
          <div class="cart-item-table commun-table">          
            <div class="row" style="border: 10px solid #ececec">
              <div class="ship-add">
                <div id="btn-div">
                <!-- ///////////////////// -->
                  <!-- Address-1 -->
                  <form method="POST" action="payment.php" autocomplete="off">
                  <?php
                  $sql_address ="select * from `address` where `user_id`='$_SESSION[user_id]'";

                    if ($result=$connection->query($sql_address)) {
                        $row_cnt=$result->num_rows;
                        if($row_cnt > 0){
                            while($row=$result->fetch_assoc()){
                  ?>
                  <div class="col-xs-12 col-md-6 add-slt">
                    <div class="row">
                      <div class="col-xs-1 col-md-1" style="padding: 10px;">
                        <input type="radio" name="address_select" value="<?php print $row['id']; ?>" checked>
                      </div>
                      <div class="col-xs-11 mb-xs-10 p-20 no-pad">
                        <div class="product-title">
                          <h4><?php print $row['name']; ?></h4>
                          <p><?php print $row['address']; ?></p>
                          <p><strong>City :</strong> <?php print $row['city']; ?> ,<strong>State :</strong> <?php print $row['state']; ?></p>
                          <p>PH : <?php print $row['contact_no']; ?></p>
                          <p>Email : <?php print $row['email']; ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php
                            }
                        }
                    }
                    ?>
                <!-- ///////////////////// -->
                  <div class="col-xs-12 col-md-12">
                    <hr>
                    <div class="mtb-20 flex-center" style="justify-content: space-around;">
                      <a class="btn btn-black" onclick="myFunction()">Add Shipping Address</a>
                        <button type="submit" name="submit" class="btn btn-black">Proceed To Payment</button>
                        </form>
                    </div>
                  </div>
                </div>  
                <div class="col-xs-12 col-md-12"> 
                  <!-- Add Address Content Section -->
                  <div class="checkout-section mtb-20" id="myDIV" style="display: none;">
                    <form action="php/add_address.php" class="main-form full" autocomplete="off" method="POST">
                      <div class="mb-20">
                        <div class="row">
                          <div class="col-xs-12 mb-20">
                            <div class="heading-part">
                              <h3 class="sub-heading">Add Shipping Address</h3>
                            </div>
                            <hr>
                          </div>
                          <div class="col-sm-12">
                            <div class="input-box">
                              <input type="text" required="" name="name" placeholder="Name">
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-box">
                              <input type="email" required="" name="email" placeholder="Email Address">
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-box">
                              <input type="text" required="" name="contact_no" placeholder="Contact Number">
                            </div>
                          </div>
                          <div class="col-sm-12">
                            <div class="input-box">
                              <textarea type="text" class="ship-textarea" colspan="3" placeholder="Please provide house number, street name and locality." name="address"></textarea>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-box">
                              <input type="text" required="" name="city" placeholder="Enter City">
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-box">
                              <input type="text" required="" name="postal_code" placeholder="Postcode/zip">
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-box">
                              <input type="text" required="" name="state" placeholder="Enter State">
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="input-box">
                              <input type="text" required="" name="country" placeholder="Enter Country">
                            </div>
                          </div>
                          <div class="col-sm-12">
                            <a class="btn btn-black" onclick="myFunction1()">Cancel</a>
                            <button type="submit" name="submit" class="btn btn-black">Confirm Shipping Address</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- Add Address Content Section -->
                </div>
              </div>
            </div>
          </div>
        </div>        
        <div class="col-sm-4 no-pad">
          <div class="cart-total-table commun-table">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th colspan="2">Cart Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Item(s) Subtotal</td>
                    <td>
                      <div class="price-box">
                        <span class="price">
                            ₹
                            <?php
                            if (!empty($_SESSION['cart'])) {
                                if( count($_SESSION['cart']) > 0 ){

                                    $total = 0;

                                    foreach ($_SESSION['cart'] as $product_id => $quantity) {
                                            if($sql_product = $connection->query("select `products`.*, `product_name`.`banner`, `product_name`.`pro_name` from `products`, `product_name` where `products`.`id` = '$product_id' and `products`.`pro_name_id` = `product_name`.`pro_name_id`")){
                                            while($row_product = $sql_product->fetch_assoc()){
                                                $total_pieces = ($row_product['standard_packing_in_piece'] * $quantity);
                                                $sub_total = ($row_product['per_piece_price'] * $total_pieces);

                                                $total = $total + $sub_total;
                                            }
                                        }
                                    }
                                }
                            }

                            print $total;
                            ?>
                        </span>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td>Discount Amount</td>
                    <td>
                      <div class="price-box">
                        <span class="price">
                            <?php
                            if (!empty($_SESSION['discount'])) {
                                $discount = ($total * $_SESSION['discount']) / 100;

                                print "₹ $discount";
                            } else
                            print "₹ 0";
                            ?>
                        </span>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><b>Amount Payable</b></td>
                    <td>
                      <div class="price-box">
                        <span class="price"><b>
                            ₹ <?php
                                $payable_amount = $total - $discount;

                                print $payable_amount;
                                ?>
                        </b></span>
                      </div>
                    </td>
                  </tr> 
                </tbody>
              </table>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </section>

<script>
function myFunction() {
  var x = document.getElementById("myDIV");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  var y = document.getElementById("btn-div");
  if (y.style.display === "none") {
    y.style.display = "block";
  } else {
    y.style.display = "none";
  }
}
function myFunction1() {
  var x = document.getElementById("myDIV");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
  var y = document.getElementById("btn-div");
  if (y.style.display === "none") {
    y.style.display = "block";
  } else {
    y.style.display = "none";
  }
}
</script>
  <!-- CONTAINER END --> 
<?php include 'include/footer.php';?>  
 