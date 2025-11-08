<?php

session_start();
require_once '../classes/Cart.php';

$c = new Cart;

$c->remove_from_cart($_SESSION['cid']);

header('Location: ../cart.php');
exit;
