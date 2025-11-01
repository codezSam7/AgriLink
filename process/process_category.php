<?php 
  require_once("../classes/Category.php");
  $c = new Category;
  
  if(isset($_POST["add"])){
    $catname = $_POST["cat_name"];

    if(empty($catname)){
      $_SESSION["errormsg"] = "Please, enter a category";
      header("location:../category.php");
      exit;
    }

    $newcat = $c->add_category($catname);
    if($newcat){
      $_SESSION["msg"] = "A new category has been added";
      header("location:../category.php");
      exit;
    }else{
      $_SESSION["errormsg"] = "Error in adding category";
      header("location:../category.php");
      exit;
    }
  }else{
    header("location:../category.php");
    exit;
  }


?>