<?php include 'include/header.php';?>
  <!-- HEADER END -->  
  
  <!-- CONTAIN START -->
  <section class="container">
    <div class="checkout-section">
      <div class="row">
        <div class="col-xs-12">
          <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-8 col-lg-offset-3 col-sm-offset-2" style="background: #eee;padding: 18px;">
              <form class="main-form full" method="POST" action="php/log.php" autocomplete="off">
                <div class="row">
                  <div class="col-xs-12 mb-20">
                    <div class="heading-part heading-bg">
                      <h2 class="heading">User Login</h2>
                    </div>
                    <center>
                    <?php
                    if (isset($_GET['msg'])) {
                        $msg = $_GET['msg'];
                        if ($msg == 1)
                            print "Invalid Authentication";
                        if ($msg == 2)
                            print "Something wrong in the server";
                        if ($msg == 3)
                            print "Please ! Enter username and password";
                    }
                    ?>
                    </center>
                  </div>
                  <div class="col-xs-12">
                    <div class="input-box">
                      <label for="login-email">Mobile No</label>
                      <input id="login-email" type="text" required="" placeholder="Email Address" name="username">
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="input-box">
                      <label for="login-pass">Password</label>
                      <input id="login-pass" type="password" required="" placeholder="Enter your Password" name="pass" >
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <div class="check-box left-side">
                      <a title="Forgot Password" class="forgot-password mtb-10" href="#">Forgot your password?</a>
                    </div>
                    <button name="submit" type="submit" class="btn-black right-side mb-10">Log In</button>
                  </div>
                  <div class="col-xs-12"><hr></div>
                  <div class="col-xs-12">
                    <div class="new-account align-center mt-20">
                      <span>New to Streetwear?</span>
                      <a class="link" title="Register with Streetwear" href="signup.php">Create New Account</a>
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