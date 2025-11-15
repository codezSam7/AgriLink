<?php

session_start();
require_once 'classes/Buyer.php';
require_once 'classes/Cart.php';
require_once 'classes/Payment.php';

$p = new Payment;
$c = new Cart;

// GET THE ACTUAL PAYSTACK REFERENCE FROM CALLBACK
$ref = $_GET['reference'] ?? null;

if (! $ref) {
    $_SESSION['msg'] = 'Invalid reference received from Paystack';
    header('location:products.php');
    exit;
}

$rsp = $p->verify_paystack_step2($ref);

// Validate properly
if ($rsp && $rsp->status == true && $rsp->data->status == 'success') {

    $paystatus = 'paid';
    $data = json_encode($rsp);

    // empty cart
    $c->empty_my_cart($_SESSION['buyer_online']);

    // Update the order table too
    $order_id = $_SESSION['order_id'];
    $p->update_order_paid($order_id); // You will create this method

} else {
    $paystatus = 'failed';
    $data = null;
}

$p->update_database($paystatus, $data, $ref);

$_SESSION['msg'] = "Payment Status : $paystatus";
header('location:products.php');
exit;
