<?php 
  //whenever a user logs in, we keep user_online
  if(!isset($_SESSION["user_online"])){
    $_SESSION["errormsg"] = "You need to be logged in to access the page";
    header("location:../../sign_farmer.php");
    exit;
  }




?>