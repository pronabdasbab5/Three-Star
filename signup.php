<?php include 'include/header.php';?>
  <!-- HEADER END -->  
  
  <!-- CONTAIN START -->
  <section class="container">
    <div class="checkout-section">
      <div class="row">
        <div class="col-xs-12">
          <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-8 col-lg-offset-3 col-sm-offset-2" style="background: #eee;padding: 18px;">
              <form class="main-form full" method="POST" action="php/signup.php" autocomplete="off">
                <div class="row">
                  <div class="col-xs-12 mb-20">
                    <div class="heading-part heading-bg">
                      <h2 class="heading">Create your account</h2>
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
                            print "You have already registered";
                    }
                    ?>
                    </center>
                  </div>
                  <div class="col-xs-6">
                    <div class="input-box">
                      <label for="f-name">Name</label>
                      <input type="text" id="f-name" name="name" required="" placeholder="First Name" required>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="input-box">
                      <label for="f-name">Company/Firm Name</label>
                      <input type="text" id="f-name" name="co_firm_name" placeholder="Company/Firm Name">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="input-box">
                      <label for="login-email">Contact No</label>
                      <input id="login-email" type="number" name="contact_no" required="" placeholder="Email Contact No" required>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="input-box">
                      <label for="login-email">Alternative No.</label>
                      <input id="login-email" type="number" name="alter_no" placeholder="Enter Alternative No.">
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="input-box">
                      <label for="login-email">Email address</label>
                      <input id="login-email" type="email" name="email" placeholder="Email Address">
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="input-box">
                      <label for="login-email">Address</label>
                      <input id="login-email" type="text" name="address" placeholder="Address">
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="input-box">
                      <label for="login-email">GST NO.</label>
                      <input id="login-email" type="text" name="gst_no" placeholder="GST NO.">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="input-box">
                      <label for="login-pass">Password</label>
                      <input id="login-pass" type="password" name="password" required="" placeholder="Enter your Password" required>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="input-box">
                      <label for="re-enter-pass">Re-enter Password</label>
                      <input id="re-enter-pass" type="password" name="con_password" required="" placeholder="Re-enter your Password" required>
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <button name="submit" type="submit" class="btn-black right-side mb-10">Submit</button>
                  </div>
                  <div class="col-xs-12">
                    <hr>
                    <div class="new-account align-center mt-20">
                      <span>Already have an account with us</span>
                      <a class="link" title="Register with Streetwear" href="login.php">Login Here</a>
                    </div>
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