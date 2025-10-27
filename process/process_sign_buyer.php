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
    $state_id = isset($_POST['delvstate']) ? (int)$_POST['delvstate'] : 0;
    $lga_id   = isset($_POST['delvlga'])   ? (int)$_POST['delvlga']   : 0;

    if(empty($fullname) || empty($email) || empty($password) || empty($phone)){
      $_SESSION["errormsg"] = "All the fields are required";
      header("location:../pages/sign_buyer.php"); exit;
    }
    if($password != $confirm_password){
      $_SESSION["errormsg"] = "The two passwords must match";
      header("location:../pages/sign_buyer.php"); exit;
    }
    
    if(!$state_id || !$lga_id){
      $_SESSION["errormsg"] = "Please choose a state and LGA";
      header("location:../pages/sign_buyer.php"); exit;
    }

    $rsp = $buyer->register_buyer($fullname, $phone, $email, $password, $state_id, $lga_id);
    if($rsp){
      $_SESSION["msg"] = "An account has been created for you";
      header("location:../pages/login_farmer.php");
      exit;
    }else{
      $_SESSION["errormsg"] = "Error in creating account, try again later";
      header("location:../pages/sign_buyer.php");
      exit;
    }
  } else {
    header("location:../pages/sign_buyer.php"); exit;
  }







?>