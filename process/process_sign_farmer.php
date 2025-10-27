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

    //validate
    if(empty($fullname) || empty($email) || empty($password) || empty($farmname) || empty($phone)){
      $_SESSION["errormsg"] = "All the fields are required";
      header("location:../pages/sign_farmer.php");
      exit;
    }
    if($password != $confirm_password){
      $_SESSION["errormsg"] = "The two passwords must match";
      header("location:../pages/sign_farmer.php");
      exit;
    }

    $rsp = $farmer->register_farmer($fullname,$farmname,$phone,$email,$password);
    if($rsp){
      $_SESSION["msg"] = "An account has been created for you";
      header("location:../pages/login_farmer.php");
      exit;
    }else{
      $_SESSION["errormsg"] = "Error in creating account, try again later";
      header("location:../pages/sign_farmer.php");
      exit;
    }
  }else{
    header("location:../pages/sign_farmer.php");
    exit;
  }



?>