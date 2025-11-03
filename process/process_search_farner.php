<?php 
  session_start();
  $f = new Farmer;
  require_once("../classes/Farmer.php");
  if(isset($_POST["btnsearch"])){
    $search = $_POST["search"];
    $state_id = isset($_POST['delvstate']) ? (int)$_POST['delvstate'] : 0;
    $lga_id   = isset($_POST['delvlga'])   ? (int)$_POST['delvlga']   : 0;

    if(empty($search)){
      $_SESSION["errormsg"] = "The search input should not be empty";
      header("location:../farmers/farmers.php");
      exit;
    }

    if(!$state_id || !$lga_id){
      $_SESSION["errormsg"] = "Please choose a state and LGA";
      header("location:../farmers/sign_farmer.php"); 
      exit;
    }

    $farmers = $f->fetch_all_states
  }


?>