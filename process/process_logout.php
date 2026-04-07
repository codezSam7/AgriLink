<?php

session_start();
require_once __DIR__ . '/../classes/Farmer.php';
require_once __DIR__ . '/../classes/Buyer.php';
require_once __DIR__ . '/../classes/Logistics.php';

$f = new Farmer;
$b = new Buyer;
$l = new Logistics;

$f->logout();
$b->blogout();
$l->llogout();

$_SESSION['msg'] = 'You have logged out successfully';
header('location:../index.php');
exit;

// stdtgvillhtkxbts
