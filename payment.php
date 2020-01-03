<?php
session_start();
if (empty($_SESSION['user_id']))
    header('location: login.php');

if (empty($_SESSION['cart']))
    header('location: index.php');

include 'include/header.php';

if (isset($_POST['submit'])) {
    if (!empty($_POST['address_select'])) {
        $_SESSION['address_id'] = $connection->real_escape_string(mysql_entities_fix_string($_POST['address_select']));
    }
    else
        header('location: checkout.php');
}

//Start of SQL Injection Function
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc())
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function
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
                <span class="hidden-xs" style="color: #ff6666;font-weight: 700;">Shipping</span>
              </a>
            </li>
            <li class="active">
              <a href="payment.php">
                <div class="step">
                  <div class="line"></div>
                  <div class="circle">3</div>
                </div>
                <span class="" style="color: #ff6666;font-weight: 700;">Payment</span>
              </a>
            </li>
            <li>
              <a href="confirmation.php">
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
        <form method="POST" action="php/payment_confirmation.php" autocomplete="off">
        <div class="col-sm-8 mb-xs-30">
          <div class="checkout-content">
            <div class="row">
              <div class="col-xs-12">
                <div class="heading-part align-center">
                    <h2 class="heading">Select a payment method</h2>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-xs-12">
                <div class="payment-option-box mb-30">
                  <div class="payment-option-box-inner gray-bg">
                    <div class="payment-top-box">
                      <div class="radio-box left-side">
                        <span style="position: absolute;left: 32px;">
                          <input type="radio" id="cash" value="online" name="payment_type" required>
                        </span>
                        <label for="cash">Would you like to pay by <strong>online</strong>?</label><br>
                        <b>(Through online payment, You will get 2% extra discount)</b>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-xs-12">
                <div class="payment-option-box mb-30">
                  <div class="payment-option-box-inner gray-bg">
                    <div class="payment-top-box">
                      <div class="radio-box left-side">
                        <span style="position: absolute;left: 32px;">
                          <input type="radio" id="cash" value="offline" name="payment_type" required>
                        </span>
                        <label for="cash">Would you like to pay by <strong>offline</strong>?</label>
                      </div>
                    </div>
                  </div>
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
                        <span class="price"><?php
                            if (!empty($_SESSION['discount'])) {
                                $discount = ($total * $_SESSION['discount']) / 100;

                                print "₹ $discount";
                            } else
                            print "₹ 0";
                            ?> </span>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td><b>Amount Payable</b></td>
                    <td>
                      <div class="price-box">
                        <span class="price"><b>
                            ₹
                            <?php
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
            <div class="col-xs-12 p-0 flex-center">
              <div class="mt-30">
                <button type="submit" name="submit" class="btn btn-black">Place Order</button>
              </div>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </section>

  <!-- CONTAINER END -->
<?php include 'include/footer.php';?> 