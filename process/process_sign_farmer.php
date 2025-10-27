<?php 
  session_start();
  require_once("../classes/User.php");
  $farmer = new User;

  if(isset($_POST["btn"])){
    $fullname = $_POST["fullname"];
    $farmname = $_POST["farmname"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["cpassword"];
    $state_id = isset($_POST['delvstate']) ? (int)$_POST['delvstate'] : 0;
    $lga_id   = isset($_POST['delvlga'])   ? (int)$_POST['delvlga']   : 0;

    //validate
    if(empty($fullname) || empty($email) || empty($password) || empty($farmname) || empty($phone)){
      $_SESSION["errormsg"] = "All the fields are required";
      header("location:../sign_farmer.php");
      exit;
    }
    if($password != $confirm_password){
      $_SESSION["errormsg"] = "The two passwords must match";
      header("location:../sign_farmer.php");
      exit;
    }

    if(!$state_id || !$lga_id){
      $_SESSION["errormsg"] = "Please choose a state and LGA";
      header("location:../sign_buyer.php"); 
      exit;
    }

    $rsp = $farmer->register_farmer($fullname,$farmname,$phone,$email,$password,$state_id,$lga_id);
    if($rsp){
      $_SESSION["msg"] = "An account has been created for you";
      header("location:../login_farmer.php");
      exit;
    }else{
      $_SESSION["errormsg"] = "Error in creating account, try again later";
      header("location:../sign_farmer.php");
      exit;
    }
  }else{
    header("location:../sign_farmer.php");
    exit;
  }



?>