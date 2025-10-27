<?php 
  session_start();
  require_once("../classes/User.php");
  $log = new User;

  if(isset($_POST["btn"])){
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if(empty($fullname) || empty($email) || empty($password)){
      $_SESSION["errormsg"] = "All fields are required";
      header("location:../pages/login_farmer.php");
      exit;
    }
    
    $response = $log->login_farmer($fullname,$email,$password);

    if($response){
      $_SESSION["msg"] = "$fullname, You are logged in successfully";
      header("location:../index.php");
      exit;
    }else{
      $_SESSION["errormsg"] = "Error occured, please try again";
      header("location:../pages/login_farmer.php");
      exit;
    }

  }else{
    $_SESSION["errormsg"] = "Please complete the form";
    header("location:../pages/login_farmer.php");
    exit;
  }



?>