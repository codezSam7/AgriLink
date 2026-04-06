<?php

session_start();

require_once 'classes/Cart.php';
require_once 'classes/Buyer.php';

$c = new Cart;
$b = new Buyer;

$cart_items = $c->fetch_buyer_cart($_SESSION['buyer_online']);
// echo "<pre>";
// print_r($cart_items);
// echo "</pre>";
// die();

$rsp = $b->insert_order_details($cart_items, $_SESSION['buyer_online']);
// echo "<pre>";
// var_dump($rsp);
// echo "</pre>";
if ($rsp) {
    $_SESSION['order_id'] = $rsp;
    header('location: order_confirm.php');
    exit;
} else {
    $_SESSION['errormsg'] = 'Order could not be placed, please try again';
    header('location: cart.php');
    exit;
}
