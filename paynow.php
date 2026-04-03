<?php

session_start();
require_once 'classes/Buyer.php';
require_once 'classes/Payment.php';
require_once 'classes/Utility.php';

$b = new Buyer;
$p = new Payment;

if (! isset($_SESSION['order_id'])) {
    $_SESSION['errormsg'] = 'Please, start the transaction again';
    header('location:cart.php');
    exit;
}

$amt = $b->fetch_order_amount($_SESSION['order_id']);
$ref = Utility::generate_ref();
// keep the ref in session
$_SESSION['refno'] = $ref;
// insert into the payment table
$p->insert_payment($amt, $_SESSION['buyer_online'], $_SESSION['order_id'], $ref);
// send to paystack
$deets = $b->get_buyer_details($_SESSION['buyer_online']);
$email = $deets['buyer_email'];
$rsp = $p->initialize_paystack_step1($email, $amt, $ref);

if ($rsp->status == true) {
    $auth_url = $rsp->data->authorization_url;
    header("location:$auth_url");
    exit;
} else {
    $_SESSION['errormsg'] = 'We could not connect to Paystack' . $rsp->message;
    header('location:cart.php');
    exit;
}

// echo "<pre>";
//   print_r($data);
// echo "</pre>";
