<?php

session_start();

require_once '../classes/Cart.php';
$c = new Cart;
$c->empty_my_cart($_SESSION['buyer_online']);

header('location:../cart.php');
exit;
