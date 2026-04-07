<?php

session_start();
require_once __DIR__ . '/../classes/Cart.php';

$c = new Cart;

$cart_id = $_GET['cid'] ?? null;

if ($cart_id) {
    $c->remove_from_cart($cart_id);
}

header('location: ../cart.php');
exit;
