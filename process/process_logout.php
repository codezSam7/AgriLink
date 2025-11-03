<?php 
  session_start();
  require_once("../classes/Farmer.php");
  require_once("../classes/Buyer.php");

  $f = new Farmer;
  $b = new Buyer;

  $f->logout();
  $b->blogout();

  $_SESSION["msg"] = "You have logged out successfully";
  header("location:../index.php");
  exit;



?>