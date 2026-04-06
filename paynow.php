<?php
session_start();

require_once 'config/constants.php';
require_once 'classes/Buyer.php';
require_once 'classes/Payment.php';
require_once 'classes/Utility.php';

$b = new Buyer();
$p = new Payment();

if (!isset($_SESSION['order_id'])) {
    $_SESSION['errormsg'] = 'Please start the transaction again';
    header('Location: cart.php');
    exit;
}

$order_id = $_SESSION['order_id'];
$buyer_id = $_SESSION['buyer_online'];

$amt = $b->fetch_order_amount($order_id);
// var_dump($amt);
// die();

if (!$amt || $amt <= 0) {
    $_SESSION['errormsg'] = 'Invalid order amount';
    header('location: cart.php');
    exit;
}

$ref = Utility::generate_ref();
$_SESSION['refno'] = $ref;

$deets = $b->get_buyer_details($buyer_id);
$email = $deets['buyer_email'] ?? null;

if (!$email) {
    $_SESSION['errormsg'] = 'User email not found';
    header('Location: cart.php');
    exit;
}

$rsp = $p->initialize_paystack_step1($email, $amt, $ref);

if ($rsp && $rsp->status == true) {

    $p->insert_payment($amt, $buyer_id, $order_id, $ref);

    $auth_url = $rsp->data->authorization_url;

    header("Location: $auth_url");
    exit;
} else {

    $msg = $rsp->message ?? 'Unknown error';

    $_SESSION['errormsg'] = 'Payment failed: ' . $msg;
    header('Location: cart.php');
    exit;
}
