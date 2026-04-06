<?php
session_start();

require_once 'config/constants.php';
require_once 'classes/Cart.php';
require_once 'classes/Payment.php';
require_once 'classes/Order.php';

$p = new Payment();
$c = new Cart();
$o = new Order();

$ref = $_GET['reference'] ?? $_SESSION['refno'] ?? null;

if (!$ref) {
    $_SESSION['errormsg'] = 'Invalid payment reference';
    header('Location: cart.php');
    exit;
}

$rsp = $p->verify_paystack_step2($ref);

if ($rsp && $rsp->status == true && $rsp->data->status == 'success') {

    if (!isset($_SESSION['order_id']) || !isset($_SESSION['buyer_online'])) {
        $_SESSION['errormsg'] = "Session expired. Contact support.";
        header("Location: cart.php");
        exit;
    }

    $order_id = $_SESSION['order_id'];
    $buyer_id = $_SESSION['buyer_online'];

    $data = json_encode($rsp);

    $p->update_database('paid', $data, $ref);

    $o->update_payment_status($order_id, 'Paid');

    $c->clear_cart($buyer_id);

    unset($_SESSION['order_id']);
    unset($_SESSION['refno']);

    $_SESSION['successmsg'] = "Payment successful!";
    header("location: buyers/buyer_orders.php");
    exit;
} else {

    $data = $rsp ? json_encode($rsp) : null;

    $p->update_database('failed', $data, $ref);

    $_SESSION['errormsg'] = "Payment failed or cancelled.";
    header("location: cart.php");
    exit;
}
