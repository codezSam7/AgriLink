<?php

session_start();
require_once '../classes/Cart.php';

$c = new Cart;

// get cart id from query string
$cart_id = $_GET['cid'] ?? null;

if ($cart_id) {
    $c->remove_from_cart($cart_id);
}

header('location: ../cart.php');
exit;

// session_start();
// require_once '../classes/Cart.php';

// $c = new Cart;

// $c->remove_from_cart($_SESSION['cid']);

// header('Location: ../cart.php');
// exit;
