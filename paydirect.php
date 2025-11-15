<?php

session_start();
require_once 'classes/Cart.php';
require_once 'classes/Payment.php';

$p = new Payment;
$c = new Cart;

$ref = $_SESSION['refno'];
$order_id = $_SESSION['order_id'];

$rsp = $p->verify_paystack_step2($ref);

if ($rsp && $rsp->status == true) {
    // verify as many things you want to verify and then update your table
    $paystatus = 'paid';
    $data = json_encode($rsp);
    // empty the cart
    $c->empty_my_cart($_SESSION['buyer_online']);
} else {
    $paystatus = 'failed';
    $data = null;
}
$p->update_database($paystatus, $data, $ref);
$_SESSION['msg'] = "Payment Status : $paystatus";
header('location:cart.php');
exit;
// echo "<pre>";
//   print_r($rsp);
// echo "</pre>";
// we want to update the database for the order_id and the payment ref

// refid should be unique alwways
