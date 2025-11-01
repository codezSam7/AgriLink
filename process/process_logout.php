<?php 
  session_start();
  require_once("../classes/Farmer.php");

  $f = new Farmer;
  $f->logout();

  $_SESSION["msg"] = "You have logged out successfully";
  header("location:../farmers/login_farmer.php");
  exit;



?>