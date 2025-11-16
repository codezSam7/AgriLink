<?php

session_start();
require_once '../classes/Farmer.php';
require_once '../classes/Buyer.php';
require_once '../classes/Logistics.php';

$f = new Farmer;
$b = new Buyer;
$l = new Logistics;

$f->logout();
$b->blogout();
$l->llogout();

$_SESSION['msg'] = 'You have logged out successfully';
header('location:../index.php');
exit;
