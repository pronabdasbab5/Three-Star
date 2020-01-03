<?php
session_start();
unset($_SESSION['admin_user_id']);
session_destroy();
header("location:../index.php");
?>