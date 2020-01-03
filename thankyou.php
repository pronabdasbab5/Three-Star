<?php 
session_start();

if (empty($_SESSION['user_id'])) 
    header('location: login.php');

include 'include/header.php';

if(!empty($_GET['payment_status'])) {
    if($_GET['payment_status'] == "Credit") {
        $sql_payment_info = "UPDATE `orders` SET `payment_status`=1, `payment_id`='$_GET[payment_id]' WHERE `payment_request_id`='$_GET[payment_request_id]' AND `user_id`='$_SESSION[user_id]'";
        mysqli_query($connection, $sql_payment_info);
    }
}
?>
  <!-- CONTAINER START -->  
  
  <!-- CONTAIN START ptb-95-->
  <section class="container">
    <div class="ptb-55 error-block-main">
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
                <span class="hidden-xs" style="color: #ff6666;font-weight: 700;">Payment</span>
              </a>
            </li>
            <li class="active">
              <a href="confirmation.php">
                <div class="step">
                  <div class="line"></div>
                  <div class="circle">4</div>
                </div>
                <span class="" style="color: #ff6666;font-weight: 700;">Order Confirm</span>
              </a>
            </li> 
          </ul>
          <hr>
        </div>
        <div class="col-xs-12">
          <div class="error-block-detail error-block-bg">
            <div class="row">
              <div class="col-sm-6 col-lg-offset-3" style="padding:20px 12px;border: 10px solid #ececec">
                <div class="main-error">
                  <img src="images/confirmation.jpg" alt="" width="25%">
                </div>
                <h1 >Your Order Has Been Placed</h1>
                <div class="mt-40"><a href="myorder.php" class="btn btn-black big">My Orders</a>  <a href="index.php" class="btn btn-black big">Back to Home</a> </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- CONTAINER END --> 

<?php include 'include/footer.php';?> 