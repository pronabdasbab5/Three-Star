<?php

require_once "include/header.php";

if (!empty($_GET['user_id'])){

    $user_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['user_id']));

    $sql_user = "SELECT * FROM `user` WHERE `id`='$user_id'";

    if ($result_user = $connection->query($sql_user))
        $row_user = $result_user->fetch_assoc();
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

<!-- page content -->
        <div class="right_col" role="main">
          <div class="">

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>User Information</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table class="table table-hover">
                        <tr>
                          <th scope="row">Name</th>
                          <td><?php print $row_user['name']; ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Name of Firm</th>
                          <td><?php print $row_user['name_of_firm']; ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Email</th>
                          <td><?php print $row_user['email']; ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Contact No</th>
                          <td><?php print $row_user['contact_no']; ?></td>
                        </tr>
                        <tr>
                          <th scope="row">GST No.</th>
                          <td><?php print $row_user['gst_no']; ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Address</th>
                          <td><?php print $row_user['address']; ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Alternative No.</th>
                          <td><?php print $row_user['alter_no']; ?></td>
                        </tr>
                        <tr>
                          <th scope="row">Discount</th>
                          <td><?php print $row_user['discount']; ?></td>
                        </tr>
                    </table>
                    <button type="button" class="btn btn-denger" onclick ="window.close();">Window Close</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

<?php
require_once "include/footer.php";
?>