<?php 
session_start();

if (empty($_SESSION['user_id'])) 
    header('location: login.php');

include 'include/header.php';

/** User Info. **/
$sql_user = $connection->query("select * from `user` where `id` = '$_SESSION[user_id]'");
$row_user = $sql_user->fetch_assoc();
?>
  <!-- HEADER END -->  
  
  <!-- CONTAIN START -->
  <section class="container">
    <div class="checkout-section">
      <div class="row">
        <div class="col-xs-12">
          <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-8 col-lg-offset-3 col-sm-offset-2" style="background: #eee;padding: 18px;">
              <form class="main-form full" method="POST" action="php/update_profile.php" autocomplete="off">
                <div class="row">
                  <div class="col-xs-12 mb-20">
                    <div class="heading-part heading-bg">
                      <h2 class="heading">Update your infomation</h2>
                    </div>
                    <center>
                    <?php
                    if (isset($_GET['msg'])) {
                        $msg = $_GET['msg'];
                        if ($msg == 1)
                            print "Fields are empty";
                        if ($msg == 2)
                            print "Password and Confirm Password are not same";
                        if ($msg == 3)
                            print "Something wrong in the server";
                        if ($msg == 4)
                            print "Profile has been updated";
                    }
                    ?>
                    </center>
                  </div>
                  <div class="col-xs-6">
                    <div class="input-box">
                      <label for="f-name">Name</label>
                      <input type="text" id="f-name" name="name" value="<?php print $row_user['name']; ?>" placeholder="First Name" required>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="input-box">
                      <label for="f-name">Company/Firm Name</label>
                      <input type="text" id="f-name" name="co_firm_name" value="<?php print $row_user['name_of_firm']; ?>" placeholder="Company/Firm Name">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="input-box">
                      <label for="login-email">Alternative No.</label>
                      <input id="login-email" type="number" name="alter_no" value="<?php print $row_user['alter_no']; ?>" placeholder="Enter Alternative No.">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="input-box">
                      <label for="login-email">Email address</label>
                      <input id="login-email" type="email" name="email" value="<?php print $row_user['email']; ?>" placeholder="Email Address">
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="input-box">
                      <label for="login-email">Address</label>
                      <input id="login-email" type="text" value="<?php print $row_user['address']; ?>" name="address" placeholder="Address">
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="input-box">
                      <label for="login-email">GST NO.</label>
                      <input id="login-email" type="text" value="<?php print $row_user['gst_no']; ?>" name="gst_no" placeholder="GST NO.">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="input-box">
                      <label for="login-pass">Password</label>
                      <input id="login-pass" value="<?php print $row_user['password']; ?>" type="password" name="password" required="" placeholder="Enter your Password" required>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="input-box">
                      <label for="re-enter-pass">Re-enter Password</label>
                      <input id="re-enter-pass" value="<?php print $row_user['password']; ?>" type="text" name="con_password" required="" placeholder="Re-enter your Password" required>
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <button name="submit" type="submit" class="btn-black right-side mb-10">Update</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- CONTAINER END --> 

  <!-- FOOTER START -->
<?php include 'include/footer.php';?>   