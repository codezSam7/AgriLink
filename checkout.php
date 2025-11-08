<?php 
  session_start();

  require_once("classes/Cart.php");
  require_once("classes/User.php");

  $c = new Cart;
  $b = new User;

  //To transfer the content of cards to order_details and the order table for the logged in user
  $cart_items = $c->get_my_cart($_SESSION["user_online"]);
  // echo "<pre>";
  //   print_r($cart_items);
  // echo "</pre>";
  // die();
  //
  $rsp = $b->insert_order_details($cart_items,$_SESSION["user_online"]);
  if($rsp){//this means an order has been placed, $rsp is the order_id
    $_SESSION["order_id"] = $rsp;
    header("location:order_confirm.php");
    exit;
  }else{
    $_SESSION["errormsg"] = "Order could not be placed, please try again";
    header("location:cart.php");
    exit;
  }

?>