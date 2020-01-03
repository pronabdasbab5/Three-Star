<?php 
session_start();

include 'include/header.php';
?>
  <!-- CONTAINER START --> 

  <section class="container">
    <div class="pb-55 pt-55">
      <div class="row">
        <div class="col-sm-2"></div>              
        <div class="col-sm-8 mb-xs-30">
          <div class="cart-item-table commun-table"> 
            <!-- Payment -->
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th colspan="4">
                      <ul>
                        <li><span>Order placed</span> <span>17 January 2017</span></li>
                        <li class="price-box"><span>Total</span> <span class="price">$160.00</span></li>
                        <li><span>Order No.</span> <span>#011052</span></li>
                      </ul>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <a href="product-page.html">
                        <div class="product-image"><img alt="Streetwear" src="images/1.jpg"></div>
                      </a>
                    </td>
                    <td>
                      <div class="product-title">
                        <a href="product-page.html">Cross Colours Camo Print Tank half mengo</a>
                      </div>
                      <div class="product-info-stock-sku m-0">
                        <div>
                          <label>Quantity: </label>
                          <span class="info-deta">1</span>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="base-price price-box">
                        <span class="price">$80.00</span>
                      </div>
                    </td>
                    <td>
                      <i title="Remove Item From Cart" data-id="100" class="fa fa-trash cart-remove-item"></i>
                    </td>
                  </tr>
                  <tr>
                    <td>
                      <a href="product-page.html">
                          <div class="product-image"><img alt="Streetwear" src="images/2.jpg"></div>
                      </a>
                    </td>
                    <td>
                      <div class="product-title">
                        <a href="product-page.html">Defyant Reversible Dot Shorts</a>
                      </div>
                      <div class="product-info-stock-sku m-0">
                        <div>
                          <label>Quantity: </label>
                          <span class="info-deta">1</span>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="base-price price-box">
                        <span class="price">$80.00</span>
                      </div>
                    </td>
                    <td>
                      <i title="Remove Item From Cart" data-id="100" class="fa fa-trash cart-remove-item"></i>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>            
            <!-- Payment -->
          </div>
        </div>       
        <div class="col-sm-2"></div>
      </div>
      <div class="mb-30">
        <div class="row">
          <div class="col-xs-12 p-0 flex-center">
            <div class="mt-30">
              <a href="shop.html" class="btn btn-black">Continue Shopping</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CONTAINER END --> 
<?php include 'include/footer.php';?>  
 