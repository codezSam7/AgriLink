<?php 
  // process/process_sign_buyer.php
  session_start();
  require_once("../classes/User.php");
  $buyer = new User;

  if(isset($_POST["btn"])){
    $fullname = trim($_POST["fullname"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["cpassword"];

    if(empty($fullname) || empty($email) || empty($password) || empty($phone)){
      $_SESSION["errormsg"] = "All the fields are required";
      header("location:../buyers/sign_buyer.php"); 
      exit;
    }
    if($password != $confirm_password){
      $_SESSION["errormsg"] = "The two passwords must match";
      header("location:../buyers/sign_buyer.php"); 
      exit;
    }

    $rsp = $buyer->register_buyer($fullname, $phone, $email, $password);
    if($rsp){
      $_SESSION["msg"] = "An account has been created for you";
      header("location:../farmers/login_farmer.php");
      exit;
    }else{
      $_SESSION["errormsg"] = "Error in creating account, try again later";
      header("location:../buyers/sign_buyer.php");
      exit;
    }
  } else {
    header("location:../buyers/sign_buyer.php"); exit;
  }







?>