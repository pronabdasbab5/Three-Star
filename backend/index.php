<?php
//Include Databse Connection Page
require_once "database/connection.php";
//Include Finish

//Start Checking User Authentication
if(isset($_POST['log_in'])){

    $email    = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
    $password = $connection->real_escape_string(mysql_entities_fix_string($_POST['password']));

    if (!empty($email) && !empty($password)) {

        $msg = "";
        
        $user_sql="SELECT * FROM `admin` WHERE `user_name` = '$email'";

        if ($user_result=$connection->query($user_sql)) {

            if($user_result->num_rows > 0) {

                $user_row=$user_result->fetch_assoc();

                if (password_verify($password,$user_row['password'])) {

                    session_start();

                    $_SESSION['admin_user_id']   = $user_row['admin_id'];
                    $_SESSION['admin_name']      = $user_row['f_name']." ".$user_row['l_name'];
                    $_SESSION['last_login_date'] = $user_row['lst_lg_dt'];

                    header("location: admin/dashboard.php");
                    
                } else
                    $msg = 3;
            } else
                $msg = 2;
        } else
            $msg = 4;
    }
    else
        $msg = 1;
}
//End of Checking User Authentication

//Start of Messsage Checking Function
function showMessage($msg) {

    if ($msg == 1)
        print "<p class='alert alert-danger'>Please ! Enter required fields</p>";
    if ($msg == 3)
        print "<p class='alert alert-danger'>Password Does Not Matched</p>";
    if ($msg == 2)
        print "<p class='alert alert-danger'>Email Id Not Exist In Our Database</p>";
    if ($msg == 4)
        print "<p class='alert alert-danger'>Something Went Wrong Please Try Again</p>";
}
//End of Messsage Checking Function

//Start of SQL Injection Function
function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
//End of SQL Injection Function
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Three Star Admin Login</title>
    <link rel="icon" type="image/ico" href="uploads/icon.png">

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
          <section class="login_content">
            <form method="POST" autocomplete="off">
              <h1>Login Form</h1>
                <?php
                if (isset($msg)) 
                    showMessage($msg);
                ?>
              <div>
                <input type="email" name="user_id" class="form-control" placeholder="Enter User Id" required />
              </div>
              <div>
                <input type="password" name="password" class="form-control" placeholder="Enter Password" required />
              </div>
              <div>
                <!-- <a class="btn btn-default submit" href="index.html">Log in</a> -->
                <input class="btn btn-default submit" type="submit" name="log_in" value="Log in">
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><img src="" height="50"></h1>
                  <p>©2016 All Rights Reserved. Developed By Web Infotech</p>
                </div>
              </div>
            </form>
          </section>
      </div>
    </div>
  </body>
</html>
