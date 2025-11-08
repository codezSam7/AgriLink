<?php 
  session_start();
  require_once("../classes/Farmer.php");

  if(isset($_POST["add"])){
    $name = $_POST["name"];
    $category = $_POST["category"];
    $desc = $_POST["desc"];
    $unit = $_POST["unit"];
    $price = $_POST["price"];
    $qtyavail = $_POST["qtyavail"];

    $f = new Farmer;
    if(empty($name) || empty($category) || empty($desc) || empty($price) || empty($qtyavail)){
      $_SESSION["errormsg"] = "All information about your product is needed";
      header("location:../farmers/farmers.php");
      exit;
    }
    if($_FILES["file"]["error"] == 0){
      //file was selected for upload
      $fileerror = $_FILES["file"]["error"];
      $filesize = $_FILES["file"]["size"];
      $filename = $_FILES["file"]["name"];
      $filetmp = $_FILES["file"]["tmp_name"];
      $uploaded_file = $f->upload_file($fileerror, $filesize, $filename, $filetmp);
    }else{
      $uploaded_file = "avatar.png";
    }
    $rsp = $f->add_product($name,$_SESSION["farmer_online"],$category,$desc,$unit,$price,$qtyavail,$uploaded_file);
    if($rsp){
      $_SESSION["msg"] = "Product added successfully"."✔";
      header("location:../products.php");
      exit;
    }else{
      $_SESSION["errormsg"] = "Error in adding product"."😢";
      header("location:../products.php");
      exit;
    }
  }else{
    header("location:../products.php");
    exit;
  }


?>